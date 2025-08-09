<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            $message = $request->input('message');
            $userId = auth()->id() ?? 'guest_' . uniqid();

            // Kiểm tra AI chat có được bật không
            if (!$this->settings->ai_chat_enabled) {
                return response()->json([
                    'success' => false,
                    'message' => 'AI Chat Bot hiện đang tạm ngưng. Vui lòng thử lại sau.'
                ]);
            }

            // Rate limiting cho guest users
            if (!auth()->check()) {
                $guestLimit = $this->settings->ai_guest_limit ?? 5;
                $guestKey = 'guest_chat_' . request()->ip();
                $guestCount = cache()->get($guestKey, 0);

                if ($guestCount >= $guestLimit) {
                    return response()->json([
                        'success' => false,
                        'message' => "Bạn đã vượt quá giới hạn chat ({$guestLimit} tin nhắn/giờ). Vui lòng đăng nhập để tiếp tục hoặc thử lại sau 1 giờ."
                    ]);
                }

                cache()->put($guestKey, $guestCount + 1, 3600); // 1 giờ
            } else {
                // Rate limiting cho user đã đăng nhập
                $userLimit = $this->settings->ai_user_limit ?? 20;
                $userKey = 'user_chat_' . $userId;
                $userCount = cache()->get($userKey, 0);

                if ($userCount >= $userLimit) {
                    return response()->json([
                        'success' => false,
                        'message' => "Bạn đã vượt quá giới hạn chat ({$userLimit} tin nhắn/giờ). Vui lòng thử lại sau 1 giờ."
                    ]);
                }

                cache()->put($userKey, $userCount + 1, 3600); // 1 giờ
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
                'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-pro:generateContent',
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent'
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
                        $data = $response->json();

                        // Kiểm tra cấu trúc response
                        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                            $aiResponse = $data['candidates'][0]['content']['parts'][0]['text'];

                            // Lấy thông tin sản phẩm để hiển thị
                            $suggestedProducts = $this->getSuggestedProducts($message);

                            // Lưu lịch sử chat vào session
                            $this->saveChatHistory($userId, $message, $aiResponse);

                            return response()->json([
                                'success' => true,
                                'ai_response' => $aiResponse,
                                'user_message' => $message,
                                'suggested_products' => $suggestedProducts
                            ]);
                        } else {
                            Log::error('Unexpected Gemini API response structure', $data);
                            $lastError = 'Cấu trúc response không đúng';
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
            return response()->json([
                'success' => false,
                'message' => 'Tất cả model đều không hoạt động. Lỗi cuối: ' . $lastError
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
                ->with(['categories:id,name', 'images'])
                ->limit(20)
                ->get();

            $productList = '';
            if ($products->count() > 0) {
                $productList = "\n\nDanh sách sản phẩm kính mắt hiện có:\n";
                foreach ($products as $product) {
                    $categoryNames = $product->categories->pluck('name')->implode(', ');
                    $categoryNames = $categoryNames ?: 'Không phân loại';

                    // Sử dụng sale_price nếu có, không thì dùng price
                    $displayPrice = $product->sale_price ?: $product->price;
                    $price = number_format($displayPrice, 0, ',', '.') . ' VNĐ';

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

        // Tạo prompt nâng cao
        return "Bạn là một chuyên gia tư vấn kính mắt tại {$storeInfo['name']}. Hãy trả lời câu hỏi của khách hàng một cách thân thiện và chuyên nghiệp bằng tiếng Việt.

THÔNG TIN CỬA HÀNG:
- Tên: {$storeInfo['name']}
- Địa chỉ: {$storeInfo['address']}
- Hotline: {$storeInfo['hotline']}
- Email: {$storeInfo['email']}" .
($storeInfo['facebook'] ? "\n- Facebook: {$storeInfo['facebook']}" : "") .
($storeInfo['instagram'] ? "\n- Instagram: {$storeInfo['instagram']}" : "") . "

CHUYÊN MÔN:
- Tư vấn chọn kính phù hợp với khuôn mặt và phong cách
- Có kiến thức về phong thủy kính mắt
- Giá cả hợp lý và dịch vụ tốt
- Hỗ trợ khách hàng tận tâm

{$productList}

Câu hỏi của khách hàng: {$userMessage}

HƯỚNG DẪN TRẢ LỜI:
1. Nếu khách hỏi về địa chỉ, hotline, email → Trả lời thông tin cửa hàng
2. Nếu khách hỏi về sản phẩm → Gợi ý từ danh sách sản phẩm có sẵn
3. Nếu khách hỏi về giá → Đề cập giá dao động từ 200k-2 triệu tùy loại kính
4. Nếu khách hỏi về tư vấn → Đưa ra lời khuyên chuyên nghiệp
5. Luôn trả lời ngắn gọn, hữu ích và thân thiện";
    }

    private function getSuggestedProducts($userMessage)
    {
        // Kiểm tra xem tin nhắn có liên quan đến sản phẩm không
        $productKeywords = ['kính', 'sản phẩm', 'mẫu', 'loại', 'giá', 'mua', 'bán', 'có gì', 'nào'];
        $hasProductIntent = false;

        foreach ($productKeywords as $keyword) {
            if (stripos($userMessage, $keyword) !== false) {
                $hasProductIntent = true;
                break;
            }
        }

        if (!$hasProductIntent) {
            return [];
        }

                // Lấy sản phẩm phù hợp
        try {
            $products = Product::where('status', 'Hoạt động')
                ->select('id', 'name', 'price', 'sale_price', 'slug', 'description_short')
                ->with(['categories:id,name', 'images'])
                ->limit(6)
                ->get();

            $suggestedProducts = [];
            foreach ($products as $product) {
                $categoryNames = $product->categories->pluck('name')->implode(', ');
                $displayPrice = $product->sale_price ?: $product->price;
                $imageUrl = $product->images->first() ? $product->images->first()->image_path : null;

                try {
                    $productUrl = route('client.products.show', $product->slug ?: $product->id);
                } catch (\Exception $e) {
                    $productUrl = '#';
                }

                $suggestedProducts[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => number_format($displayPrice, 0, ',', '.') . ' VNĐ',
                    'category' => $categoryNames ?: 'Không phân loại',
                    'image' => $imageUrl,
                    'url' => $productUrl,
                    'description' => $product->description_short
                ];
            }
        } catch (\Exception $e) {
            Log::error('Error getting suggested products: ' . $e->getMessage());
            $suggestedProducts = [];
        }

        return $suggestedProducts;
    }

    private function saveChatHistory($userId, $userMessage, $aiResponse)
    {
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
}
