    <?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\WebsiteSetting;
use App\Models\Product;

class AIChatController extends Controller
{
    private $apiKey;
    private $baseUrl;
    private $settings;

    public function __construct()
    {
        $this->settings = WebsiteSetting::first();

        if (!$this->settings) {
            throw new \Exception('Website settings chưa được cấu hình');
        }

        $this->apiKey = $this->settings->ai_api_key;
        $this->baseUrl = $this->settings->ai_api_endpoint ?: 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent';

        if (!$this->apiKey) {
            throw new \Exception('AI API Key chưa được cấu hình trong admin settings');
        }
    }

    public function chat(Request $request)
    {
        try {
            // Yêu cầu đăng nhập để chat
            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để sử dụng AI Chat',
                    'require_login' => true
                ]);
            }

            $message = $request->input('message');
            $userId = auth()->id(); // Chỉ lấy ID user đã đăng nhập

            // Kiểm tra AI chat có được bật không
            if (!$this->settings->ai_chat_enabled) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI Chat Bot hiện đang tạm ngưng. Vui lòng thử lại sau.'
                ]);
            }

            // Rate limiting cho user đã đăng nhập (5 tin nhắn/giờ)
            $userLimit = $this->settings->ai_user_limit ?? 5; // Giảm xuống 5 tin nhắn/giờ
            $userKey = 'user_chat_' . $userId;
            $userCount = cache()->get($userKey, 0);



            if ($userCount >= $userLimit) {
                return response()->json([
                    'success' => false,
                    'message' => "Bạn đã vượt quá giới hạn chat ({$userLimit} tin nhắn/giờ). Vui lòng thử lại sau 1 giờ."
                ]);
            }

            cache()->put($userKey, $userCount + 1, 3600); // 1 giờ

            if (empty($message)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập tin nhắn'
                ]);
            }

            // Lọc nội dung không phù hợp
            $filteredMessage = $this->filterInappropriateContent($message);
            if ($filteredMessage !== $message) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tin nhắn chứa nội dung không phù hợp. Vui lòng kiểm tra lại.'
                ]);
            }

            // Giới hạn độ dài tin nhắn
            if (strlen($message) > 500) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tin nhắn quá dài. Vui lòng rút gọn (tối đa 500 ký tự).'
                ]);
            }

            // Tạo prompt cho AI về kính mắt với thông tin sản phẩm và cửa hàng
            $prompt = $this->createEnhancedPrompt($message);

            // Debug: Log thông tin request
            Log::info('Gemini API Request', [
                'url' => $this->baseUrl . '?key=' . substr($this->apiKey, 0, 10) . '...',
                'prompt' => $prompt,
                'api_key_length' => strlen($this->apiKey)
            ]);

            // Thử các model khác nhau nếu model đầu tiên không hoạt động
            $models = [
                'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent',
                'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-pro:generateContent'
            ];

            $response = null;
            $lastError = null;

            foreach ($models as $modelUrl) {
                try {
                    Log::info('Trying model: ' . $modelUrl);

                    $response = Http::timeout(30)->withoutVerifying()->post($modelUrl . '?key=' . $this->apiKey, [
                        'contents' => [
                            [
                                'parts' => [
                                    [
                                        'text' => $prompt
                                    ]
                                ]
                            ]
                        ],
                        'generationConfig' => [
                            'temperature' => 0.7,
                            'topK' => 40,
                            'topP' => 0.95,
                            'maxOutputTokens' => 1024,
                        ]
                    ]);

                    // Debug: Log response
                    Log::info('Gemini API Response for ' . $modelUrl, [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'successful' => $response->successful()
                    ]);

                    if ($response->successful()) {
                        try {
                            $data = $response->json();
                            Log::info('Response data structure', [
                                'has_candidates' => isset($data['candidates']),
                                'candidates_count' => isset($data['candidates']) ? count($data['candidates']) : 0,
                                'has_content' => isset($data['candidates'][0]['content']),
                                'has_parts' => isset($data['candidates'][0]['content']['parts']),
                                'has_text' => isset($data['candidates'][0]['content']['parts'][0]['text'])
                            ]);

                            // Kiểm tra cấu trúc response
                            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                                $aiResponse = $data['candidates'][0]['content']['parts'][0]['text'];
                                Log::info('AI Response received', ['length' => strlen($aiResponse)]);

                                // Lấy thông tin sản phẩm để hiển thị
                                $suggestedProducts = $this->getSuggestedProducts($message);
                                Log::info('Suggested products', ['count' => count($suggestedProducts)]);

                                // Lưu lịch sử chat và lấy history
                                $chatHistory = $this->saveChatHistory($userId, $message, $aiResponse);

                                // Lấy thông tin filter giá
                                $priceFilter = $this->extractPriceFilter($message);

                                // Thêm thông tin về filter giá vào response
                                $responseData = [
                                    'success' => true,
                                    'ai_response' => $aiResponse,
                                    'user_message' => $message,
                                    'suggested_products' => $suggestedProducts,
                                    'chat_history' => $chatHistory
                                ];

                                // Thêm thông tin về filter nếu có
                                if ($priceFilter['price_range']) {
                                    $responseData['price_filter'] = $priceFilter;
                                }
                                // Luôn trả về số lượng sản phẩm
                                $responseData['products_count'] = count($suggestedProducts);

                                Log::info('Returning successful response');
                                return response()->json($responseData);
                            } else {
                                Log::error('Unexpected Gemini API response structure', $data);
                                $lastError = 'Cấu trúc response không đúng';
                            }
                        } catch (\Exception $e) {
                            Log::error('Error processing response data: ' . $e->getMessage());
                            $lastError = 'Lỗi xử lý response: ' . $e->getMessage();
                        }
                    } else {
                        $lastError = 'HTTP ' . $response->status() . ': ' . $response->body();
                        Log::error('Gemini API Error for ' . $modelUrl, [
                            'status' => $response->status(),
                            'body' => $response->body()
                        ]);
                    }
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                    Log::error('Exception for model ' . $modelUrl . ': ' . $e->getMessage());
                }
            }

            // Nếu tất cả model đều thất bại
            Log::error('All models failed. Last error: ' . $lastError);

            // Fallback response khi API không hoạt động
            $suggestedProducts = $this->getSuggestedProducts($message);
            $fallbackResponse = "Xin chào! Tôi là Hana AI Assistant. Hiện tại tôi đang gặp sự cố kỹ thuật tạm thời, nhưng tôi vẫn có thể gợi ý cho bạn một số sản phẩm phù hợp từ cửa hàng chúng tôi.";

            return response()->json([
                'success' => true,
                'ai_response' => $fallbackResponse,
                'user_message' => $message,
                'suggested_products' => $suggestedProducts,
                'products_count' => count($suggestedProducts),
                'is_fallback' => true,
                'api_error' => $lastError
            ]);
        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
            ]);
        }
    }

    private function createEnhancedPrompt($userMessage)
    {
        // Lấy thông tin cửa hàng từ settings
        $storeInfo = [
            'name' => $this->settings->website_name ?? 'Hana Optical',
            'address' => $this->settings->address ?? 'Chưa cập nhật',
            'hotline' => $this->settings->hotline ?? 'Chưa cập nhật',
            'email' => $this->settings->contact_email ?? 'Chưa cập nhật',
            'facebook' => $this->settings->facebook_url ?? '',
            'instagram' => $this->settings->instagram_url ?? ''
        ];

        // Lấy danh sách sản phẩm kính mắt từ database
        try {
            $products = Product::where('status', 'Hoạt động')
                ->select('id', 'name', 'price', 'sale_price', 'description_short', 'product_type', 'slug')
                ->with(['categories:id,name', 'images', 'variations' => function ($query) {
                    $query->where('status', 'Hoạt động');
                }])
                ->limit(20)
                ->get();

            $productList = '';
            if ($products->count() > 0) {
                $productList = "\n\nDanh sách sản phẩm kính mắt hiện có:\n";
                foreach ($products as $product) {
                    $categoryNames = $product->categories->pluck('name')->implode(', ');
                    $categoryNames = $categoryNames ?: 'Không phân loại';

                    // Sử dụng method getProductPrice để xử lý cả simple và variable
                    $price = $this->getProductPrice($product);

                    // Tạo link sản phẩm
                    try {
                        $productUrl = route('client.products.show', $product->slug ?: $product->id);
                    } catch (\Exception $e) {
                        $productUrl = '#';
                    }

                    $productList .= "- {$product->name} ({$categoryNames}): {$price} - Xem chi tiết: {$productUrl}\n";
                }
            }
        } catch (\Exception $e) {
            $productList = "\n\nKhông thể tải danh sách sản phẩm: " . $e->getMessage();
        }

        // Tạo prompt nâng cao với thông tin filter giá
        $priceFilterInfo = '';
        try {
            $priceFilter = $this->extractPriceFilter($userMessage);
            if ($priceFilter['price_range']) {
                $priceFilterInfo = "\n\nYÊU CẦU GIÁ: Khách hàng đang tìm sản phẩm trong khoảng giá {$priceFilter['price_range']}. Hãy tập trung gợi ý các sản phẩm phù hợp với ngân sách này.";
            }
        } catch (\Exception $e) {
            Log::error('Error extracting price filter in createEnhancedPrompt: ' . $e->getMessage());
            $priceFilterInfo = '';
        }

        return "Bạn là chuyên gia tư vấn kính mắt tại {$storeInfo['name']}. Trả lời ngắn gọn, thân thiện bằng tiếng Việt.

THÔNG TIN CỬA HÀNG:
- Tên: {$storeInfo['name']}
- Địa chỉ: {$storeInfo['address']}
- Hotline: {$storeInfo['hotline']}
- Email: {$storeInfo['email']}" .
            ($storeInfo['facebook'] ? "\n- Facebook: {$storeInfo['facebook']}" : "") .
            ($storeInfo['instagram'] ? "\n- Instagram: {$storeInfo['instagram']}" : "") . "{$priceFilterInfo}

{$productList}

Câu hỏi: {$userMessage}

HƯỚNG DẪN QUAN TRỌNG:
1. Trả lời ngắn gọn, không quá 3-4 câu
2. CHỈ gợi ý sản phẩm có trong danh sách trên, KHÔNG được tạo ra sản phẩm không có
3. Nếu hỏi 'mua kính', 'kính mắt', 'gọng kính' → CHỈ gợi ý sản phẩm KÍNH, không gợi ý phụ kiện
4. Nếu hỏi 'phụ kiện', 'hộp đựng', 'nước xịt' → gợi ý phụ kiện
5. Nếu hỏi giá → Chỉ nêu khoảng giá chung
6. Nếu hỏi địa chỉ/hotline → Chỉ trả lời thông tin cần thiết
7. KHÔNG được tạo ra tên sản phẩm, giá, hoặc thông tin không có trong danh sách
8. Tập trung vào sản phẩm thực tế có trong danh sách";
    }

    private function getSuggestedProducts($userMessage)
    {
        // Kiểm tra xem tin nhắn có liên quan đến sản phẩm không
        $productKeywords = [
            'kính',
            'sản phẩm',
            'mẫu',
            'loại',
            'giá',
            'mua',
            'bán',
            'có gì',
            'nào',
            'gọng kính',
            'tròng kính',
            'kính mắt',
            'kính râm',
            'kính cận',
            'kính viễn',
            'kính đeo',
            'kính thời trang',
            'kính nam',
            'kính nữ',
            'kính trẻ em',
            'gọng',
            'tròng',
            'mắt kính',
            'kính thuốc',
            'kính áp tròng',
            'giới thiệu',
            'cho tôi',
            'vài cái',
            'một số',
            'vài chiếc',
            'một vài'
        ];

        $hasProductIntent = false;
        $messageLower = mb_strtolower($userMessage, 'UTF-8');

        foreach ($productKeywords as $keyword) {
            if (mb_strpos($messageLower, mb_strtolower($keyword, 'UTF-8')) !== false) {
                $hasProductIntent = true;
                break;
            }
        }

        // Luôn gợi ý sản phẩm nếu có từ khóa liên quan
        if (!$hasProductIntent) {
            return [];
        }

        // Phân tích yêu cầu giá từ tin nhắn
        $priceFilter = $this->extractPriceFilter($userMessage);

        // Phân tích loại sản phẩm từ tin nhắn
        $productType = $this->extractProductType($userMessage);

        // Lấy sản phẩm phù hợp
        try {
            Log::info('Getting suggested products', [
                'message' => $userMessage,
                'price_filter' => $priceFilter
            ]);

            $query = Product::where('status', 'Hoạt động')
                ->select('id', 'name', 'price', 'sale_price', 'slug', 'description_short', 'product_type')
                ->with(['categories:id,name', 'images', 'variations' => function ($query) {
                    $query->where('status', 'Hoạt động');
                }]);

            // Filter theo loại sản phẩm
            if ($productType === 'glasses') {
                // Chỉ lấy kính mắt, loại trừ phụ kiện
                $query->whereNotIn('name', function($subQuery) {
                    $subQuery->select('name')
                        ->from('products')
                        ->whereIn('name', [
                            'Nước xịt rửa mắt kính CAO CẤP',
                            'Hộp đựng kính mắt Hana lót nhung mềm mại chống xước',
                            'Hộp da đựng mắt kính cao cấp'
                        ]);
                });
            } elseif ($productType === 'accessories') {
                // Chỉ lấy phụ kiện
                $query->whereIn('name', [
                    'Nước xịt rửa mắt kính CAO CẤP',
                    'Hộp đựng kính mắt Hana lót nhung mềm mại chống xước',
                    'Hộp da đựng mắt kính cao cấp'
                ]);
            }

            // Áp dụng filter giá nếu có
            if ($priceFilter['min_price'] !== null || $priceFilter['max_price'] !== null) {
                Log::info('Applying price filter', [
                    'min_price' => $priceFilter['min_price'],
                    'max_price' => $priceFilter['max_price']
                ]);

                // Chỉ lấy sản phẩm simple có giá cụ thể
                $query->where('product_type', 'simple');

                if ($priceFilter['min_price'] !== null) {
                    $query->where(function ($subQ) use ($priceFilter) {
                        $subQ->where('sale_price', '>=', $priceFilter['min_price'])
                            ->orWhere('price', '>=', $priceFilter['min_price']);
                    });
                }

                if ($priceFilter['max_price'] !== null) {
                    $query->where(function ($subQ) use ($priceFilter) {
                        $subQ->where('sale_price', '<=', $priceFilter['max_price'])
                            ->orWhere('price', '<=', $priceFilter['max_price']);
                    });
                }
            }

            $products = $query->orderBy('is_featured', 'desc')
                ->orderBy('views', 'desc')
                ->limit(20) // Tăng limit để có nhiều lựa chọn hơn
                ->get();

            Log::info('Products found before filtering', [
                'count' => $products->count()
            ]);

            // Lọc sản phẩm theo giá sau khi load
            if ($priceFilter['min_price'] !== null || $priceFilter['max_price'] !== null) {
                $products = $products->filter(function ($product) use ($priceFilter) {
                    if ($product->product_type === 'variable') {
                        $variations = $product->variations;
                        if ($variations->count() > 0) {
                            // Lấy giá thấp nhất và cao nhất từ variations
                            $minVariationPrice = $variations->min(function ($variation) {
                                // Ưu tiên: discount_price > sale_price > price
                                if ($variation->discount_price && $variation->discount_price > 0) {
                                    return $variation->discount_price;
                                }
                                if ($variation->sale_price && $variation->sale_price > 0) {
                                    return $variation->sale_price;
                                }
                                return $variation->price ?: 0;
                            });

                            $maxVariationPrice = $variations->max(function ($variation) {
                                // Ưu tiên: discount_price > sale_price > price
                                if ($variation->discount_price && $variation->discount_price > 0) {
                                    return $variation->discount_price;
                                }
                                if ($variation->sale_price && $variation->sale_price > 0) {
                                    return $variation->sale_price;
                                }
                                return $variation->price ?: 0;
                            });

                            // Chỉ filter nếu có giá hợp lệ
                            if ($minVariationPrice > 0 && $maxVariationPrice > 0) {
                                // Kiểm tra xem có variation nào phù hợp với filter không
                                if ($priceFilter['min_price'] !== null && $maxVariationPrice < $priceFilter['min_price']) {
                                    return false;
                                }
                                if ($priceFilter['max_price'] !== null && $minVariationPrice > $priceFilter['max_price']) {
                                    return false;
                                }
                            }
                        } else {
                            // Không có variation, kiểm tra giá từ bảng chính
                            $displayPrice = $product->sale_price ?: $product->price;
                            if ($displayPrice && $displayPrice > 0) {
                                if ($priceFilter['min_price'] !== null && $displayPrice < $priceFilter['min_price']) {
                                    return false;
                                }
                                if ($priceFilter['max_price'] !== null && $displayPrice > $priceFilter['max_price']) {
                                    return false;
                                }
                            }
                            // Nếu không có giá, vẫn hiển thị sản phẩm
                        }
                    } else {
                        // Sản phẩm simple - kiểm tra giá trực tiếp
                        $displayPrice = $product->sale_price ?: $product->price;
                        if ($displayPrice && $displayPrice > 0) {
                            if ($priceFilter['min_price'] !== null && $displayPrice < $priceFilter['min_price']) {
                                return false;
                            }
                            if ($priceFilter['max_price'] !== null && $displayPrice > $priceFilter['max_price']) {
                                return false;
                            }
                        }
                    }
                    return true;
                });
            }

            Log::info('Products found after filtering', [
                'count' => $products->count()
            ]);

            $suggestedProducts = [];
            foreach ($products as $product) {
                try {
                    $categoryNames = $product->categories->pluck('name')->implode(', ');
                    $categoryNames = $categoryNames ?: 'Không phân loại';

                    // Xử lý giá sản phẩm
                    $price = $this->getProductPrice($product);

                    // Xử lý hình ảnh sản phẩm
                    $imageUrl = null;
                    if ($product->images && $product->images->count() > 0) {
                        $firstImage = $product->images->first();
                        $imageUrl = $firstImage->image_path;

                        // Đảm bảo URL hình ảnh đúng định dạng
                        if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                            $imageUrl = asset('storage/' . $imageUrl);
                        }
                    }

                    // Tạo URL sản phẩm
                    try {
                        if ($product->slug) {
                            $productUrl = route('client.products.show', $product->slug);
                        } else {
                            // Fallback: tạo URL thủ công nếu không có slug
                            $productUrl = url('/client/products/' . $product->id);
                        }
                    } catch (\Exception $e) {
                        Log::warning('Could not generate product URL for product ID: ' . $product->id);
                        $productUrl = url('/client/products/' . $product->id);
                    }

                    // Rút gọn tên sản phẩm nếu quá dài
                    $productName = $product->name;
                    if (mb_strlen($productName) > 30) {
                        $productName = mb_substr($productName, 0, 27) . '...';
                    }

                    // Thông tin về biến thể
                    $variationInfo = '';
                    if ($product->product_type === 'variable' && $product->variations->count() > 0) {
                        $variationCount = $product->variations->count();
                        $variationInfo = " ({$variationCount} biến thể)";
                    }

                    $suggestedProducts[] = [
                        'id' => $product->id,
                        'name' => $productName,
                        'price' => $price,
                        'category' => $categoryNames,
                        'image' => $imageUrl,
                        'url' => $productUrl,
                        'description' => $product->description_short,
                        'is_featured' => $product->is_featured,
                        'views' => $product->views,
                        'product_type' => $product->product_type,
                        'variation_info' => $variationInfo
                    ];
                } catch (\Exception $e) {
                    Log::error('Error processing product', [
                        'product_id' => $product->id,
                        'error' => $e->getMessage()
                    ]);
                    continue; // Bỏ qua sản phẩm này và tiếp tục
                }
            }
        } catch (\Exception $e) {
            Log::error('Error getting suggested products: ' . $e->getMessage(), [
                'message' => $userMessage,
                'trace' => $e->getTraceAsString()
            ]);
            $suggestedProducts = [];
        }

        Log::info('Final suggested products', [
            'count' => count($suggestedProducts)
        ]);

        return $suggestedProducts;
    }

    /**
     * Trích xuất thông tin giá từ tin nhắn người dùng
     */
    private function extractPriceFilter($userMessage)
    {
        $messageLower = mb_strtolower($userMessage, 'UTF-8');
        $priceFilter = [
            'min_price' => null,
            'max_price' => null,
            'price_range' => null
        ];

        // Tìm các pattern giá tiền
        $patterns = [
            // Dưới X
            '/dưới\s*(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'max',
            '/ít\s*hơn\s*(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'max',
            '/thấp\s*hơn\s*(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'max',

            // Trên X
            '/trên\s*(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'min',
            '/nhiều\s*hơn\s*(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'min',
            '/cao\s*hơn\s*(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'min',

            // Khoảng X-Y
            '/từ\s*(\d+)\s*đến\s*(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'range',
            '/(\d+)\s*-\s*(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'range',
            '/(\d+)\s*-\s*(\d+)\s*k/i' => 'range',
            '/khoảng\s*(\d+)\s*-\s*(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'range',

            // Chỉ số
            '/(\d+)\s*(k|nghìn|ngàn|000|vnd|đ)/i' => 'exact'
        ];

        foreach ($patterns as $pattern => $type) {
            if (preg_match($pattern, $messageLower, $matches)) {
                switch ($type) {
                    case 'max':
                        $price = $this->normalizePrice($matches[1], $matches[2]);
                        $priceFilter['max_price'] = $price;
                        $priceFilter['price_range'] = "dưới " . number_format($price, 0, ',', '.') . " VNĐ";
                        break;

                    case 'min':
                        $price = $this->normalizePrice($matches[1], $matches[2]);
                        $priceFilter['min_price'] = $price;
                        $priceFilter['price_range'] = "trên " . number_format($price, 0, ',', '.') . " VNĐ";
                        break;

                    case 'range':
                        $minPrice = $this->normalizePrice($matches[1], $matches[3]);
                        $maxPrice = $this->normalizePrice($matches[2], $matches[3]);
                        $priceFilter['min_price'] = $minPrice;
                        $priceFilter['max_price'] = $maxPrice;
                        $priceFilter['price_range'] = number_format($minPrice, 0, ',', '.') . " - " . number_format($maxPrice, 0, ',', '.') . " VNĐ";
                        break;

                    case 'exact':
                        $price = $this->normalizePrice($matches[1], $matches[2]);
                        $priceFilter['max_price'] = $price;
                        $priceFilter['price_range'] = "khoảng " . number_format($price, 0, ',', '.') . " VNĐ";
                        break;
                }
                break; // Chỉ lấy pattern đầu tiên tìm thấy
            }
        }

        return $priceFilter;
    }



    /**
     * Phân tích loại sản phẩm từ tin nhắn
     */
    private function extractProductType($userMessage)
    {
        $messageLower = mb_strtolower($userMessage, 'UTF-8');

        // Từ khóa cho kính mắt
        $glassesKeywords = [
            'kính', 'gọng kính', 'kính mắt', 'kính râm', 'kính cận', 'kính viễn',
            'kính đeo', 'kính thời trang', 'kính nam', 'kính nữ', 'kính trẻ em',
            'gọng', 'tròng kính', 'mắt kính', 'kính thuốc', 'kính áp tròng'
        ];

        // Từ khóa cho phụ kiện
        $accessoryKeywords = [
            'phụ kiện', 'hộp đựng', 'nước xịt', 'khăn lau', 'dây đeo', 'bao đựng',
            'hộp kính', 'nước rửa', 'khăn', 'dây', 'bao'
        ];

        // Kiểm tra từ khóa kính mắt
        foreach ($glassesKeywords as $keyword) {
            if (mb_strpos($messageLower, $keyword) !== false) {
                return 'glasses';
            }
        }

        // Kiểm tra từ khóa phụ kiện
        foreach ($accessoryKeywords as $keyword) {
            if (mb_strpos($messageLower, $keyword) !== false) {
                return 'accessories';
            }
        }

        // Mặc định là kính mắt nếu không xác định được
        return 'glasses';
    }

    /**
     * Chuẩn hóa giá từ text sang số
     */
    private function normalizePrice($number, $unit)
    {
        $number = (int) $number;

        switch (strtolower($unit)) {
            case 'k':
            case 'nghìn':
            case 'ngàn':
                return $number * 1000;
            case '000':
                return $number * 1000;
            case 'vnd':
            case 'đ':
                return $number;
            default:
                return $number;
        }
    }

    /**
     * Lấy giá hiển thị cho sản phẩm
     */
    private function getProductPrice($product)
    {
        if ($product->product_type === 'variable') {
            // Sản phẩm có biến thể - lấy giá từ variations
            $variations = $product->variations()->where('status', 'Hoạt động')->get();

            if ($variations->count() > 0) {
                // Lấy giá thấp nhất và cao nhất từ variations
                $minPrice = $variations->min(function ($variation) {
                    // Ưu tiên: discount_price > sale_price > price
                    if ($variation->discount_price && $variation->discount_price > 0) {
                        return $variation->discount_price;
                    }
                    if ($variation->sale_price && $variation->sale_price > 0) {
                        return $variation->sale_price;
                    }
                    return $variation->price ?: 0;
                });

                $maxPrice = $variations->max(function ($variation) {
                    // Ưu tiên: discount_price > sale_price > price
                    if ($variation->discount_price && $variation->discount_price > 0) {
                        return $variation->discount_price;
                    }
                    if ($variation->sale_price && $variation->sale_price > 0) {
                        return $variation->sale_price;
                    }
                    return $variation->price ?: 0;
                });

                // Chỉ hiển thị nếu có giá hợp lệ
                if ($minPrice > 0 && $maxPrice > 0) {
                    if ($minPrice == $maxPrice) {
                        return number_format($minPrice, 0, ',', '.') . ' VNĐ';
                    } else {
                        return number_format($minPrice, 0, ',', '.') . ' - ' . number_format($maxPrice, 0, ',', '.') . ' VNĐ';
                    }
                }
            }

            // Fallback: thử lấy giá từ bảng chính nếu không có variations
            $displayPrice = $product->sale_price ?: $product->price;
            if ($displayPrice && $displayPrice > 0) {
                return number_format($displayPrice, 0, ',', '.') . ' VNĐ';
            }

            return 'Liên hệ';
        } else {
            // Sản phẩm đơn giản - lấy giá từ bảng chính
            $displayPrice = $product->sale_price ?: $product->price;
            if ($displayPrice && $displayPrice > 0) {
                return number_format($displayPrice, 0, ',', '.') . ' VNĐ';
            }
            return 'Liên hệ';
        }
    }

    private function saveChatHistory($userId, $userMessage, $aiResponse)
    {
        // Lưu vào session để có thể truy cập từ server
        $chatHistory = session("ai_chat_history_{$userId}", []);

        $chatHistory[] = [
            'user_message' => $userMessage,
            'ai_response' => $aiResponse,
            'timestamp' => now()->toISOString()
        ];

        // Giữ tối đa 20 tin nhắn gần nhất
        if (count($chatHistory) > 20) {
            $chatHistory = array_slice($chatHistory, -20);
        }

        session(["ai_chat_history_{$userId}" => $chatHistory]);

        // Trả về history để frontend lưu vào localStorage
        return $chatHistory;
    }

    public function getChatHistory(Request $request)
    {
        $userId = auth()->id() ?? 'guest_' . uniqid();
        $chatHistory = session("ai_chat_history_{$userId}", []);

        return response()->json([
            'success' => true,
            'history' => $chatHistory
        ]);
    }

    public function clearChatHistory(Request $request)
    {
        $userId = auth()->id() ?? 'guest_' . uniqid();
        session()->forget("ai_chat_history_{$userId}");

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa lịch sử chat'
        ]);
    }

    private function filterInappropriateContent($message)
    {
        // Danh sách từ khóa không phù hợp
        $inappropriateWords = [
            'fuck',
            'shit',
            'bitch',
            'asshole',
            'dick',
            'pussy',
            'đụ',
            'địt',
            'đcm',
            'đm',
            'clm',
            'cl',
            'cc',
            'đéo',
            'spam',
            'hack',
            'virus',
            'malware',
            'phishing'
        ];

        $lowerMessage = strtolower($message);

        foreach ($inappropriateWords as $word) {
            if (strpos($lowerMessage, $word) !== false) {
                return false; // Nội dung không phù hợp
            }
        }

        // Kiểm tra spam (lặp lại ký tự quá nhiều)
        if (preg_match('/(.)\1{10,}/', $message)) {
            return false;
        }

        return $message; // Nội dung hợp lệ
    }

    public function getChatStats()
    {
        // Thống kê sử dụng chat (chỉ admin)
        if (!auth()->check() || auth()->user()->role_id > 2) {
            return response()->json(['success' => false, 'message' => 'Không có quyền truy cập']);
        }

        $stats = [
            'total_requests' => cache()->get('total_chat_requests', 0),
            'guest_requests' => cache()->get('guest_chat_requests', 0),
            'user_requests' => cache()->get('user_chat_requests', 0),
            'api_errors' => cache()->get('api_errors', 0),
        ];

        return response()->json(['success' => true, 'stats' => $stats]);
    }

    public function testEnhanced()
    {
        try {
            // Test settings
            $settings = WebsiteSetting::first();
            $settingsInfo = [
                'found' => $settings ? true : false,
                'name' => $settings->website_name ?? 'Not set',
                'address' => $settings->address ?? 'Not set',
                'hotline' => $settings->hotline ?? 'Not set',
                'ai_chat_enabled' => $settings->ai_chat_enabled ?? false,
                'ai_api_key' => $settings->ai_api_key ? 'Set' : 'Not set'
            ];

            // Test products
            $products = Product::where('status', 'Hoạt động')->count();

            // Test route
            $testRoute = route('client.products.show', 'test-slug');

            return response()->json([
                'success' => true,
                'settings' => $settingsInfo,
                'products_count' => $products,
                'test_route' => $testRoute,
                'error' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function testPriceFilter()
    {
        try {
            $testMessages = [
                'Giới thiệu cho tôi vài cái kính dưới 200k',
                'Có kính nào từ 500k đến 1 triệu không?',
                'Kính trên 2 triệu có gì?',
                'Tìm kính khoảng 300k'
            ];

            $results = [];
            foreach ($testMessages as $message) {
                $priceFilter = $this->extractPriceFilter($message);
                $suggestedProducts = $this->getSuggestedProducts($message);

                $results[] = [
                    'message' => $message,
                    'price_filter' => $priceFilter,
                    'products_count' => count($suggestedProducts),
                    'products' => array_slice($suggestedProducts, 0, 3) // Chỉ lấy 3 sản phẩm đầu
                ];
            }

            return response()->json([
                'results' => $results,
                'message' => 'Price filter test completed'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }













    public function resetLimit(Request $request)
    {
        try {
            $userId = auth()->id();
            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập'
                ]);
            }

            // Reset rate limit cho user
            $userKey = 'user_chat_' . $userId;
            cache()->forget($userKey);

            return response()->json([
                'success' => true,
                'message' => 'Đã reset giới hạn chat'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}
