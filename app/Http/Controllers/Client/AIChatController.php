<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

use App\Models\WebsiteSetting;
use App\Models\Product;

class AIChatController extends Controller
{
    private $apiKey;
    private $baseUrl;
    private $settings;
    private $cacheTtl = 3600; // 1 giờ
    private $maxRetries = 3;

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
        $startTime = microtime(true);

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
            $userId = auth()->id();

            // Kiểm tra AI chat có được bật không
            if (!$this->settings->ai_chat_enabled) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI Chat Bot hiện đang tạm ngưng. Vui lòng thử lại sau.'
                ]);
            }

            // Rate limiting thông minh hơn với Redis
            $rateLimitResult = $this->checkRateLimit($userId);
            if (!$rateLimitResult['allowed']) {
                return response()->json([
                    'success' => false,
                    'message' => $rateLimitResult['message']
                ]);
            }

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

            // Kiểm tra cache trước khi gọi API
            $cacheKey = $this->generateCacheKey($message, $userId);
            $cachedResponse = Cache::get($cacheKey);

            if ($cachedResponse) {
                Log::info("AI Chat: Cache hit for user {$userId}", [
                    'message_length' => strlen($message),
                    'cache_key' => $cacheKey
                ]);

                // Cập nhật rate limit và trả về response từ cache
                $this->updateRateLimit($userId);
                return response()->json($cachedResponse);
            }

            // Tạo prompt cho AI về kính mắt với thông tin sản phẩm và cửa hàng
            $prompt = $this->createEnhancedPrompt($message);

            // Gọi API AI với retry mechanism
            $aiResponse = $this->callAIWithRetry($prompt);

            if (!$aiResponse) {
                // Fallback response khi API không hoạt động
                $suggestedProducts = $this->getSuggestedProducts($message);
                $fallbackResponse = "Xin chào! Tôi là Hana AI Assistant. Hiện tại tôi đang gặp sự cố kỹ thuật tạm thời, nhưng tôi vẫn có thể gợi ý cho bạn một số sản phẩm phù hợp từ cửa hàng chúng tôi.";

                $responseData = [
                    'success' => true,
                    'ai_response' => $fallbackResponse,
                    'user_message' => $message,
                    'suggested_products' => $suggestedProducts,
                    'products_count' => count($suggestedProducts),
                    'is_fallback' => true
                ];

                // Cache fallback response
                Cache::put($cacheKey, $responseData, $this->cacheTtl);

                return response()->json($responseData);
            }

            // Lấy thông tin sản phẩm để hiển thị
            $suggestedProducts = $this->getSuggestedProducts($message);

            // Trích xuất sản phẩm từ câu trả lời của AI
            $extractedProducts = $this->extractProductsFromAIResponse($aiResponse);

            // Kết hợp sản phẩm gợi ý và sản phẩm được trích xuất
            $allProducts = array_merge($suggestedProducts, $extractedProducts);

            // Loại bỏ trùng lặp dựa trên ID sản phẩm
            $uniqueProducts = [];
            $seenIds = [];
            foreach ($allProducts as $product) {
                if (!in_array($product['id'], $seenIds)) {
                    $uniqueProducts[] = $product;
                    $seenIds[] = $product['id'];
                }
            }

            // Lưu lịch sử chat và lấy history
            $chatHistory = $this->saveChatHistory($userId, $message, $aiResponse);

            // Lấy thông tin filter giá
            $priceFilter = $this->extractPriceFilter($message);

            // Thêm thông tin về filter giá vào response
            $responseData = [
                'success' => true,
                'ai_response' => $aiResponse,
                'user_message' => $message,
                'suggested_products' => $uniqueProducts,
                'chat_history' => $chatHistory
            ];

            // Thêm thông tin về filter nếu có
            if ($priceFilter['price_range']) {
                $responseData['price_filter'] = $priceFilter;
            }

            // Luôn trả về số lượng sản phẩm
            $responseData['products_count'] = count($uniqueProducts);

            // Cache response thành công
            Cache::put($cacheKey, $responseData, $this->cacheTtl);

            // Log performance metrics
            $executionTime = microtime(true) - $startTime;
            Log::info("AI Chat: Success for user {$userId}", [
                'message_length' => strlen($message),
                'execution_time' => round($executionTime * 1000, 2) . 'ms',
                'products_count' => count($uniqueProducts),
                'cache_hit' => false
            ]);

            return response()->json($responseData);
        } catch (\Exception $e) {
            $executionTime = microtime(true) - $startTime;
            Log::error('AI Chat Error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'message' => $message ?? 'N/A',
                'execution_time' => round($executionTime * 1000, 2) . 'ms',
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại sau'
            ]);
        }
    }

    /**
     * Kiểm tra rate limit thông minh với Redis
     */
    private function checkRateLimit($userId)
    {
        $userLimit = $this->settings->ai_user_limit ?? 5;
        $userKey = "ai_chat_rate_limit_{$userId}";
        $ipKey = "ai_chat_ip_limit_" . request()->ip();

        // Kiểm tra limit theo user
        $userCount = Cache::get($userKey, 0);
        if ($userCount >= $userLimit) {
            $timeLeft = Cache::get("{$userKey}_expires", 0);
            $remainingTime = max(0, $timeLeft - time());

            return [
                'allowed' => false,
                'message' => "Bạn đã vượt quá giới hạn chat ({$userLimit} tin nhắn/giờ). Vui lòng thử lại sau " . ceil($remainingTime / 60) . " phút."
            ];
        }

        // Kiểm tra limit theo IP (chống spam)
        $ipLimit = 20; // 20 tin nhắn/giờ theo IP
        $ipCount = Cache::get($ipKey, 0);
        if ($ipCount >= $ipLimit) {
            return [
                'allowed' => false,
                'message' => "Quá nhiều yêu cầu từ IP này. Vui lòng thử lại sau 1 giờ."
            ];
        }

        return ['allowed' => true];
    }

    /**
     * Cập nhật rate limit
     */
    private function updateRateLimit($userId)
    {
        $userKey = "ai_chat_rate_limit_{$userId}";
        $ipKey = "ai_chat_ip_limit_" . request()->ip();

        // Cập nhật user limit
        $userCount = Cache::get($userKey, 0);
        Cache::put($userKey, $userCount + 1, 3600);
        Cache::put("{$userKey}_expires", time() + 3600, 3600);

        // Cập nhật IP limit
        $ipCount = Cache::get($ipKey, 0);
        Cache::put($ipKey, $ipCount + 1, 3600);
    }

    /**
     * Tạo cache key duy nhất
     */
    private function generateCacheKey($message, $userId)
    {
        $messageHash = md5($message);
        return "ai_chat_response_{$userId}_{$messageHash}";
    }

    /**
     * Gọi API AI với retry mechanism
     */
    private function callAIWithRetry($prompt)
    {
        $models = [
            'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent',
            'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-pro:generateContent'
        ];

        $lastError = null;

        for ($attempt = 1; $attempt <= $this->maxRetries; $attempt++) {
            foreach ($models as $modelUrl) {
                try {
                    $response = Http::timeout(30)
                        ->withoutVerifying()
                        ->post($modelUrl . '?key=' . $this->apiKey, [
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

                    if ($response->successful()) {
                        $data = $response->json();

                        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                            Log::info("AI API: Success on attempt {$attempt}", [
                                'model' => $modelUrl,
                                'attempt' => $attempt
                            ]);

                            return $data['candidates'][0]['content']['parts'][0]['text'];
                        }
                    }
                } catch (\Exception $e) {
                    $lastError = $e->getMessage();
                    Log::warning("AI API: Attempt {$attempt} failed for model {$modelUrl}", [
                        'error' => $lastError,
                        'attempt' => $attempt
                    ]);

                    // Đợi một chút trước khi retry
                    if ($attempt < $this->maxRetries) {
                        sleep(1);
                    }
                }
            }
        }

        Log::error("AI API: All attempts failed after {$this->maxRetries} retries", [
            'last_error' => $lastError
        ]);

        return null;
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

        // Phân tích ý định người dùng
        $intent = $this->analyzeUserIntent($userMessage);
        $priceFilter = $this->extractPriceFilter($userMessage);
        $productType = $this->extractProductType($userMessage);

        // Lấy danh sách sản phẩm kính mắt từ database
        try {
            $products = Product::where('status', 'Hoạt động')
                ->select('id', 'name', 'price', 'sale_price', 'description_short', 'product_type', 'slug', 'brand_id', 'is_featured', 'views')
                ->with(['categories:id,name', 'brand:id,name', 'images', 'variations' => function ($query) {
                    $query->where('status', 'Hoạt động');
                }])
                ->limit(30)
                ->get();

            $productList = '';
            if ($products->count() > 0) {
                $productList = "\n\nDANH SÁCH SẢN PHẨM HIỆN CÓ:\n";
                foreach ($products as $product) {
                    $categoryNames = $product->categories->pluck('name')->implode(', ');
                    $categoryNames = $categoryNames ?: 'Không phân loại';
                    $brandName = $product->brand ? $product->brand->name : 'Không có thương hiệu';

                    // Sử dụng method getProductPrice để xử lý cả simple và variable
                    $price = $this->getProductPrice($product);

                    // Tạo link sản phẩm
                    try {
                        $productUrl = route('client.products.show', $product->slug ?: $product->id);
                    } catch (\Exception $e) {
                        $productUrl = '#';
                    }

                    $featuredTag = $product->is_featured ? ' [NỔI BẬT]' : '';
                    $viewsInfo = $product->views > 0 ? " (Xem: {$product->views})" : '';

                    $productList .= "- {$product->name} ({$brandName} - {$categoryNames}): {$price}{$featuredTag}{$viewsInfo} - Xem chi tiết: {$productUrl}\n";
                }
            }
        } catch (\Exception $e) {
            $productList = "\n\nKhông thể tải danh sách sản phẩm: " . $e->getMessage();
        }

        // Tạo prompt nâng cao với thông tin filter giá
        $priceFilterInfo = '';
        if ($priceFilter['price_range']) {
            $priceFilterInfo = "\n\nYÊU CẦU GIÁ: Khách hàng đang tìm sản phẩm trong khoảng giá {$priceFilter['price_range']}. Hãy tập trung gợi ý các sản phẩm phù hợp với ngân sách này.";
        }

        // Thông tin về ý định tìm kiếm
        $searchIntentInfo = '';
        if ($intent['exact_search']) {
            $searchIntentInfo = "\n\nÝ ĐỊNH TÌM KIẾM: Khách hàng đang tìm kiếm sản phẩm cụ thể. Hãy giúp họ tìm đúng sản phẩm họ cần.";
        }
        if ($intent['keyword_search'] && !empty($intent['keywords'])) {
            $keywords = implode(', ', $intent['keywords']);
            $searchIntentInfo = "\n\nTỪ KHÓA TÌM KIẾM: Khách hàng đang tìm kiếm với từ khóa: {$keywords}. Hãy gợi ý sản phẩm phù hợp.";
        }

        // Thông tin về loại sản phẩm
        $productTypeInfo = '';
        if ($productType === 'glasses') {
            $productTypeInfo = "\n\nLOẠI SẢN PHẨM: Khách hàng đang tìm kính mắt, không phải phụ kiện.";
        } elseif ($productType === 'accessories') {
            $productTypeInfo = "\n\nLOẠI SẢN PHẨM: Khách hàng đang tìm phụ kiện kính mắt.";
        }

        return "Bạn là chuyên gia tư vấn kính mắt tại {$storeInfo['name']}. Trả lời ngắn gọn, thân thiện bằng tiếng Việt.

THÔNG TIN CỬA HÀNG:
- Tên: {$storeInfo['name']}
- Địa chỉ: {$storeInfo['address']}
- Hotline: {$storeInfo['hotline']}
- Email: {$storeInfo['email']}" .
            ($storeInfo['facebook'] ? "\n- Facebook: {$storeInfo['facebook']}" : "") .
            ($storeInfo['instagram'] ? "\n- Instagram: {$storeInfo['instagram']}" : "") .
            $priceFilterInfo . $searchIntentInfo . $productTypeInfo . "

{$productList}

Câu hỏi: {$userMessage}

HƯỚNG DẪN QUAN TRỌNG:
1. Trả lời ngắn gọn, không quá 3-4 câu
2. CHỈ gợi ý sản phẩm có trong danh sách trên, KHÔNG được tạo ra sản phẩm không có
3. Nếu khách hàng tìm kiếm sản phẩm cụ thể → Giúp họ tìm đúng sản phẩm đó
4. Nếu khách hàng hỏi về thương hiệu → Gợi ý sản phẩm của thương hiệu đó
5. Nếu khách hàng hỏi về loại kính → Gợi ý sản phẩm phù hợp với loại đó
6. Nếu hỏi 'mua kính', 'kính mắt', 'gọng kính' → CHỈ gợi ý sản phẩm KÍNH, không gợi ý phụ kiện
7. Nếu hỏi 'phụ kiện', 'hộp đựng', 'nước xịt' → gợi ý phụ kiện
8. Nếu hỏi giá → Chỉ nêu khoảng giá chung
9. Nếu hỏi địa chỉ/hotline → Chỉ trả lời thông tin cần thiết
10. KHÔNG được tạo ra tên sản phẩm, giá, hoặc thông tin không có trong danh sách
11. Tập trung vào sản phẩm thực tế có trong danh sách
12. Ưu tiên gợi ý sản phẩm nổi bật và có nhiều lượt xem
13. Nếu không tìm thấy sản phẩm phù hợp → Thông báo và gợi ý sản phẩm tương tự
14. LUÔN đề cập đến tên sản phẩm cụ thể khi gợi ý, ví dụ: 'Gọng kính Hana 1576 (450.000 VNĐ)'
15. Khi gợi ý sản phẩm, luôn kèm theo giá trong ngoặc đơn
16. Nếu có nhiều sản phẩm phù hợp, chỉ gợi ý 2-3 sản phẩm tiêu biểu nhất";
    }

    private function getSuggestedProducts($userMessage)
    {
        // Cache key cho sản phẩm gợi ý
        $cacheKey = 'ai_chat_products_' . md5($userMessage);

        // Kiểm tra cache trước
        $cachedProducts = Cache::get($cacheKey);
        if ($cachedProducts) {
            Log::info("AI Chat: Products cache hit", ['message_hash' => md5($userMessage)]);
            return $cachedProducts;
        }

        // Phân tích tin nhắn để tìm ý định
        $intent = $this->analyzeUserIntent($userMessage);

        // Nếu không có ý định tìm sản phẩm, trả về mảng rỗng
        if (!$intent['has_product_intent']) {
            return [];
        }

        // Phân tích yêu cầu giá và loại sản phẩm
        $priceFilter = $this->extractPriceFilter($userMessage);
        $productType = $this->extractProductType($userMessage);

        try {
            $query = Product::where('status', 'Hoạt động')
                ->select('id', 'name', 'price', 'sale_price', 'slug', 'description_short', 'product_type', 'is_featured', 'views', 'brand_id')
                ->with([
                    'categories:id,name',
                    'images:id,product_id,image_path',
                    'brand:id,name',
                    'variations' => function ($query) {
                        $query->where('status', 'Hoạt động')
                            ->select('id', 'product_id', 'price', 'sale_price', 'discount_price', 'status');
                    }
                ]);

            // Tìm kiếm theo tên sản phẩm chính xác
            if ($intent['exact_search']) {
                $exactProducts = $this->searchExactProducts($userMessage, $query);
                if (!empty($exactProducts)) {
                    Cache::put($cacheKey, $exactProducts, 1800);
                    return $exactProducts;
                }
            }

            // Tìm kiếm theo từ khóa cụ thể
            if ($intent['keyword_search']) {
                $keywordProducts = $this->searchByKeywords($intent['keywords'], $query);
                if (!empty($keywordProducts)) {
                    Cache::put($cacheKey, $keywordProducts, 1800);
                    return $keywordProducts;
                }
            }

            // Filter theo loại sản phẩm
            if ($productType === 'glasses') {
                $query->whereNotIn('name', [
                    'Nước xịt rửa mắt kính CAO CẤP',
                    'Hộp đựng kính mắt Hana lót nhung mềm mại chống xước',
                    'Hộp da đựng mắt kính cao cấp'
                ]);
            } elseif ($productType === 'accessories') {
                $query->whereIn('name', [
                    'Nước xịt rửa mắt kính CAO CẤP',
                    'Hộp đựng kính mắt Hana lót nhung mềm mại chống xước',
                    'Hộp da đựng mắt kính cao cấp'
                ]);
            }

            // Áp dụng filter giá nếu có
            if ($priceFilter['min_price'] !== null || $priceFilter['max_price'] !== null) {
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

            // Sử dụng database indexing để tối ưu performance
            $products = $query->orderBy('is_featured', 'desc')
                ->orderBy('views', 'desc')
                ->limit(20)
                ->get();

            // Lọc sản phẩm theo giá sau khi load (tối ưu hóa)
            if ($priceFilter['min_price'] !== null || $priceFilter['max_price'] !== null) {
                $products = $products->filter(function ($product) use ($priceFilter) {
                    return $this->isProductInPriceRange($product, $priceFilter);
                });
            }

            // Xử lý sản phẩm với batch processing để tối ưu memory
            $suggestedProducts = $this->processProductsBatch($products);

            // Cache kết quả để tái sử dụng
            Cache::put($cacheKey, $suggestedProducts, 1800); // Cache 30 phút

        } catch (\Exception $e) {
            Log::error('AI Chat: Error getting suggested products', [
                'error' => $e->getMessage(),
                'message' => $userMessage
            ]);
            $suggestedProducts = [];
        }

        return $suggestedProducts;
    }

    /**
     * Phân tích ý định người dùng từ tin nhắn
     */
    private function analyzeUserIntent($userMessage)
    {
        $messageLower = mb_strtolower($userMessage, 'UTF-8');

        // Từ khóa cho ý định tìm sản phẩm
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
            'một vài',
            'tìm',
            'kiếm',
            'xem',
            'có',
            'bán',
            'mua',
            'giá',
            'bao nhiêu'
        ];

        // Từ khóa cho tìm kiếm chính xác
        $exactSearchKeywords = [
            'tìm',
            'kiếm',
            'có',
            'bán',
            'mua',
            'xem',
            'chi tiết',
            'thông tin'
        ];

        // Từ khóa cho thương hiệu
        $brandKeywords = [
            'ray-ban',
            'ray ban',
            'gucci',
            'prada',
            'oakley',
            'tom ford',
            'versace',
            'dolce',
            'gabbana',
            'armani',
            'burberry',
            'cartier',
            'chanel',
            'dior',
            'fendi',
            'hermes',
            'louis vuitton',
            'lv',
            'michael kors',
            'mk',
            'tiffany'
        ];

        $hasProductIntent = false;
        $exactSearch = false;
        $keywords = [];

        // Kiểm tra ý định tìm sản phẩm
        foreach ($productKeywords as $keyword) {
            if (mb_strpos($messageLower, mb_strtolower($keyword, 'UTF-8')) !== false) {
                $hasProductIntent = true;
                break;
            }
        }

        // Kiểm tra tìm kiếm chính xác
        foreach ($exactSearchKeywords as $keyword) {
            if (mb_strpos($messageLower, mb_strtolower($keyword, 'UTF-8')) !== false) {
                $exactSearch = true;
                break;
            }
        }

        // Trích xuất từ khóa thương hiệu
        foreach ($brandKeywords as $brand) {
            if (mb_strpos($messageLower, mb_strtolower($brand, 'UTF-8')) !== false) {
                $keywords[] = $brand;
            }
        }

        // Trích xuất từ khóa từ tin nhắn (loại bỏ các từ không cần thiết)
        $stopWords = ['tôi', 'muốn', 'có', 'thể', 'cho', 'với', 'về', 'của', 'này', 'đó', 'kia', 'nào', 'gì', 'bao', 'nhiêu', 'và', 'hoặc', 'nhưng', 'mà', 'thì', 'là', 'đang', 'sẽ', 'đã', 'được', 'bởi', 'từ', 'đến', 'trong', 'ngoài', 'trên', 'dưới', 'trước', 'sau', 'giữa', 'bên', 'cạnh', 'gần', 'xa', 'cao', 'thấp', 'lớn', 'nhỏ', 'dài', 'ngắn', 'rộng', 'hẹp', 'dày', 'mỏng', 'nặng', 'nhẹ', 'đắt', 'rẻ', 'tốt', 'xấu', 'đẹp', 'xấu', 'mới', 'cũ', 'sạch', 'bẩn', 'nóng', 'lạnh', 'ấm', 'mát', 'khô', 'ướt', 'cứng', 'mềm', 'cứng', 'mềm', 'sáng', 'tối', 'sáng', 'tối', 'nhanh', 'chậm', 'nhanh', 'chậm', 'dễ', 'khó', 'dễ', 'khó', 'có', 'không', 'có', 'không', 'đúng', 'sai', 'đúng', 'sai', 'cùng', 'khác', 'cùng', 'khác', 'giống', 'khác', 'giống', 'khác', 'bằng', 'không', 'bằng', 'không', 'hơn', 'kém', 'hơn', 'kém', 'nhiều', 'ít', 'nhiều', 'ít', 'tất', 'cả', 'mỗi', 'một', 'một', 'số', 'vài', 'vài', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín', 'mười', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín', 'mười'];

        $words = preg_split('/\s+/', $messageLower);
        foreach ($words as $word) {
            $word = trim($word, '.,!?;:()[]{}"\'-');
            if (mb_strlen($word) > 2 && !in_array($word, $stopWords)) {
                $keywords[] = $word;
            }
        }

        return [
            'has_product_intent' => $hasProductIntent,
            'exact_search' => $exactSearch,
            'keywords' => array_unique($keywords),
            'keyword_search' => !empty($keywords)
        ];
    }

    /**
     * Tìm kiếm sản phẩm theo tên chính xác
     */
    private function searchExactProducts($userMessage, $query)
    {
        $messageLower = mb_strtolower($userMessage, 'UTF-8');

        // Tìm các từ khóa có thể là tên sản phẩm
        $potentialProductNames = [];

        // Tách từ khóa từ tin nhắn
        $words = preg_split('/\s+/', $messageLower);
        foreach ($words as $word) {
            $word = trim($word, '.,!?;:()[]{}"\'-');
            if (mb_strlen($word) > 2) {
                $potentialProductNames[] = $word;
            }
        }

        $foundProducts = collect();

        foreach ($potentialProductNames as $name) {
            // Tìm kiếm theo tên sản phẩm
            $products = clone $query;
            $exactMatches = $products->whereRaw('LOWER(name) LIKE ?', ["%{$name}%"])
                ->orWhereRaw('LOWER(description_short) LIKE ?', ["%{$name}%"])
                ->get();

            if ($exactMatches->count() > 0) {
                $foundProducts = $foundProducts->merge($exactMatches);
            }
        }

        // Loại bỏ trùng lặp và giới hạn kết quả
        $uniqueProducts = $foundProducts->unique('id')->take(10);

        return $this->processProductsBatch($uniqueProducts);
    }

    /**
     * Tìm kiếm sản phẩm theo từ khóa
     */
    private function searchByKeywords($keywords, $query)
    {
        $foundProducts = collect();

        foreach ($keywords as $keyword) {
            if (mb_strlen($keyword) < 3) continue;

            $products = clone $query;
            $matches = $products->where(function ($q) use ($keyword) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"])
                    ->orWhereRaw('LOWER(description_short) LIKE ?', ["%{$keyword}%"])
                    ->orWhereHas('categories', function ($catQ) use ($keyword) {
                        $catQ->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"]);
                    })
                    ->orWhereHas('brand', function ($brandQ) use ($keyword) {
                        $brandQ->whereRaw('LOWER(name) LIKE ?', ["%{$keyword}%"]);
                    });
            })->get();

            if ($matches->count() > 0) {
                $foundProducts = $foundProducts->merge($matches);
            }
        }

        // Loại bỏ trùng lặp và sắp xếp theo độ phù hợp
        $uniqueProducts = $foundProducts->unique('id');

        // Tính điểm phù hợp cho mỗi sản phẩm
        $scoredProducts = $uniqueProducts->map(function ($product) use ($keywords) {
            $score = 0;
            $productText = mb_strtolower($product->name . ' ' . $product->description_short, 'UTF-8');

            foreach ($keywords as $keyword) {
                if (mb_strpos($productText, $keyword) !== false) {
                    $score += 1;
                }
            }

            // Thêm điểm cho sản phẩm nổi bật và có nhiều lượt xem
            if ($product->is_featured) $score += 2;
            $score += min($product->views / 100, 5); // Tối đa 5 điểm cho lượt xem

            return ['product' => $product, 'score' => $score];
        });

        // Sắp xếp theo điểm và lấy top 10
        $topProducts = $scoredProducts->sortByDesc('score')
            ->take(10)
            ->pluck('product');

        return $this->processProductsBatch($topProducts);
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
            'kính',
            'gọng kính',
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
            'tròng kính',
            'mắt kính',
            'kính thuốc',
            'kính áp tròng'
        ];

        // Từ khóa cho phụ kiện
        $accessoryKeywords = [
            'phụ kiện',
            'hộp đựng',
            'nước xịt',
            'khăn lau',
            'dây đeo',
            'bao đựng',
            'hộp kính',
            'nước rửa',
            'khăn',
            'dây',
            'bao'
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
            $userKey = 'ai_chat_rate_limit_' . $userId;
            $ipKey = 'ai_chat_ip_limit_' . request()->ip();

            Cache::forget($userKey);
            Cache::forget("{$userKey}_expires");
            Cache::forget($ipKey);

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

    /**
     * Kiểm tra sản phẩm có trong khoảng giá không
     */
    private function isProductInPriceRange($product, $priceFilter)
    {
        if ($product->product_type === 'variable') {
            $variations = $product->variations;
            if ($variations->count() > 0) {
                $minVariationPrice = $variations->min(function ($variation) {
                    if ($variation->discount_price && $variation->discount_price > 0) {
                        return $variation->discount_price;
                    }
                    if ($variation->sale_price && $variation->sale_price > 0) {
                        return $variation->sale_price;
                    }
                    return $variation->price ?: 0;
                });

                $maxVariationPrice = $variations->max(function ($variation) {
                    if ($variation->discount_price && $variation->discount_price > 0) {
                        return $variation->discount_price;
                    }
                    if ($variation->sale_price && $variation->sale_price > 0) {
                        return $variation->sale_price;
                    }
                    return $variation->price ?: 0;
                });

                if ($minVariationPrice > 0 && $maxVariationPrice > 0) {
                    if ($priceFilter['min_price'] !== null && $maxVariationPrice < $priceFilter['min_price']) {
                        return false;
                    }
                    if ($priceFilter['max_price'] !== null && $minVariationPrice > $priceFilter['max_price']) {
                        return false;
                    }
                }
            } else {
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
        } else {
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
    }

    /**
     * Xử lý sản phẩm theo batch để tối ưu memory
     */
    private function processProductsBatch($products)
    {
        $suggestedProducts = [];

        foreach ($products as $product) {
            try {
                $categoryNames = $product->categories->pluck('name')->implode(', ');
                $categoryNames = $categoryNames ?: 'Không phân loại';

                $price = $this->getProductPrice($product);
                $imageUrl = $this->getProductImageUrl($product);
                $productUrl = $this->getProductUrl($product);
                $productName = $this->truncateProductName($product->name);
                $variationInfo = $this->getVariationInfo($product);

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
                Log::warning('AI Chat: Error processing product', [
                    'product_id' => $product->id ?? 'unknown',
                    'error' => $e->getMessage()
                ]);
                continue;
            }
        }

        return $suggestedProducts;
    }

    /**
     * Lấy URL hình ảnh sản phẩm
     */
    private function getProductImageUrl($product)
    {
        if ($product->images && $product->images->count() > 0) {
            $imageUrl = $product->images->first()->image_path;
            if ($imageUrl && !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                return asset('storage/' . $imageUrl);
            }
            return $imageUrl;
        }
        return null;
    }

    /**
     * Tạo URL sản phẩm
     */
    private function getProductUrl($product)
    {
        try {
            if ($product->slug) {
                return route('client.products.show', $product->slug);
            }
            return url('/client/products/' . $product->id);
        } catch (\Exception $e) {
            Log::warning('AI Chat: Could not generate product URL', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            return url('/client/products/' . $product->id);
        }
    }

    /**
     * Rút gọn tên sản phẩm
     */
    private function truncateProductName($name, $maxLength = 30)
    {
        if (mb_strlen($name) > $maxLength) {
            return mb_substr($name, 0, $maxLength - 3) . '...';
        }
        return $name;
    }

    /**
     * Lấy thông tin biến thể
     */
    private function getVariationInfo($product)
    {
        if ($product->product_type === 'variable' && $product->variations->count() > 0) {
            $variationCount = $product->variations->count();
            return " ({$variationCount} biến thể)";
        }
        return '';
    }

    /**
     * Trích xuất sản phẩm từ câu trả lời của AI
     */
    private function extractProductsFromAIResponse($aiResponse)
    {
        $extractedProducts = [];

        try {
            // Tìm các pattern sản phẩm trong câu trả lời của AI
            $patterns = [
                // Pattern: "Tên sản phẩm (giá)"
                '/[A-Za-zÀ-ỹ\s]+(?:\s+\d+)?\s*\(([0-9,\.]+)\s*(?:VNĐ|đ|k|nghìn|ngàn)\)/u',
                // Pattern: "Tên sản phẩm - giá"
                '/[A-Za-zÀ-ỹ\s]+(?:\s+\d+)?\s*[-–]\s*([0-9,\.]+)\s*(?:VNĐ|đ|k|nghìn|ngàn)/u',
                // Pattern: "Tên sản phẩm giá"
                '/[A-Za-zÀ-ỹ\s]+(?:\s+\d+)?\s+([0-9,\.]+)\s*(?:VNĐ|đ|k|nghìn|ngàn)/u'
            ];

            foreach ($patterns as $pattern) {
                if (preg_match_all($pattern, $aiResponse, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $match) {
                        $productName = trim($match[0]);
                        $price = $this->normalizePriceFromText($match[1]);

                        // Tìm sản phẩm trong database dựa trên tên
                        $foundProduct = $this->findProductByName($productName);
                        if ($foundProduct) {
                            $extractedProducts[] = $foundProduct;
                        }
                    }
                }
            }

            // Tìm kiếm theo từ khóa thương hiệu
            $brandKeywords = [
                'ray-ban',
                'ray ban',
                'gucci',
                'prada',
                'oakley',
                'tom ford',
                'versace',
                'dolce',
                'gabbana',
                'armani',
                'burberry',
                'cartier',
                'chanel',
                'dior',
                'fendi',
                'hermes',
                'louis vuitton',
                'lv',
                'michael kors',
                'mk',
                'tiffany'
            ];

            foreach ($brandKeywords as $brand) {
                if (stripos($aiResponse, $brand) !== false) {
                    $brandProducts = $this->findProductsByBrand($brand);
                    $extractedProducts = array_merge($extractedProducts, $brandProducts);
                }
            }

            // Loại bỏ trùng lặp
            $uniqueProducts = [];
            $seenIds = [];
            foreach ($extractedProducts as $product) {
                if (!in_array($product['id'], $seenIds)) {
                    $uniqueProducts[] = $product;
                    $seenIds[] = $product['id'];
                }
            }

            return $uniqueProducts;
        } catch (\Exception $e) {
            Log::error('Error extracting products from AI response: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Chuẩn hóa giá từ text
     */
    private function normalizePriceFromText($priceText)
    {
        // Loại bỏ các ký tự không phải số
        $price = preg_replace('/[^0-9]/', '', $priceText);
        return (int) $price;
    }

    /**
     * Tìm sản phẩm theo tên
     */
    private function findProductByName($productName)
    {
        try {
            // Làm sạch tên sản phẩm
            $cleanName = preg_replace('/\s*\([^)]*\)/', '', $productName); // Loại bỏ phần trong ngoặc
            $cleanName = trim($cleanName);

            // Tìm sản phẩm trong database
            $product = Product::where('status', 'Hoạt động')
                ->where(function ($query) use ($cleanName) {
                    $query->whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($cleanName, 'UTF-8') . '%'])
                        ->orWhereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower(str_replace(' ', '%', $cleanName), 'UTF-8') . '%']);
                })
                ->with(['categories:id,name', 'brand:id,name', 'images:id,product_id,image_path'])
                ->first();

            if ($product) {
                return $this->formatProductForResponse($product);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Error finding product by name: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Tìm sản phẩm theo thương hiệu
     */
    private function findProductsByBrand($brandName)
    {
        try {
            $products = Product::where('status', 'Hoạt động')
                ->whereHas('brand', function ($query) use ($brandName) {
                    $query->whereRaw('LOWER(name) LIKE ?', ['%' . mb_strtolower($brandName, 'UTF-8') . '%']);
                })
                ->with(['categories:id,name', 'brand:id,name', 'images:id,product_id,image_path'])
                ->limit(5)
                ->get();

            $formattedProducts = [];
            foreach ($products as $product) {
                $formattedProducts[] = $this->formatProductForResponse($product);
            }

            return $formattedProducts;
        } catch (\Exception $e) {
            Log::error('Error finding products by brand: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Format sản phẩm cho response
     */
    private function formatProductForResponse($product)
    {
        $categoryNames = $product->categories->pluck('name')->implode(', ');
        $categoryNames = $categoryNames ?: 'Không phân loại';
        $brandName = $product->brand ? $product->brand->name : 'Không có thương hiệu';
        $price = $this->getProductPrice($product);
        $imageUrl = $this->getProductImageUrl($product);
        $productUrl = $this->getProductUrl($product);

        return [
            'id' => $product->id,
            'name' => $this->truncateProductName($product->name),
            'price' => $price,
            'category' => $categoryNames,
            'brand' => $brandName,
            'image' => $imageUrl,
            'url' => $productUrl,
            'description' => $product->description_short,
            'is_featured' => $product->is_featured,
            'views' => $product->views,
            'product_type' => $product->product_type
        ];
    }

    /**
     * Lấy thống kê performance
     */
    public function getPerformanceStats()
    {
        if (!auth()->check() || auth()->user()->role_id > 2) {
            return response()->json(['success' => false, 'message' => 'Không có quyền truy cập']);
        }

        $stats = [
            'cache_hit_rate' => $this->getCacheHitRate(),
            'average_response_time' => $this->getAverageResponseTime(),
            'total_requests' => Cache::get('ai_chat_total_requests', 0),
            'cache_size' => $this->getCacheSize(),
            'memory_usage' => memory_get_usage(true),
            'peak_memory' => memory_get_peak_usage(true)
        ];

        return response()->json(['success' => true, 'stats' => $stats]);
    }

    /**
     * Lấy tỷ lệ cache hit
     */
    private function getCacheHitRate()
    {
        $totalRequests = Cache::get('ai_chat_total_requests', 0);
        $cacheHits = Cache::get('ai_chat_cache_hits', 0);

        if ($totalRequests > 0) {
            return round(($cacheHits / $totalRequests) * 100, 2);
        }
        return 0;
    }

    /**
     * Lấy thời gian response trung bình
     */
    private function getAverageResponseTime()
    {
        $totalTime = Cache::get('ai_chat_total_time', 0);
        $totalRequests = Cache::get('ai_chat_total_requests', 0);

        if ($totalRequests > 0) {
            return round($totalTime / $totalRequests, 2);
        }
        return 0;
    }

    /**
     * Lấy kích thước cache
     */
    private function getCacheSize()
    {
        $keys = Cache::get('ai_chat_cache_keys', []);
        return count($keys);
    }
}
