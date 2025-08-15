<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use App\Models\Category;
use App\Models\Variation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm dạng lưới (client/products/index.blade.php)
     */
    public function index(Request $request)
{
    \Log::info('Search request', $request->all());
    $query = Product::with(['categories', 'brand', 'images', 'variations.color'])
        ->active();

    // Bộ lọc: Availability
    if ($request->has('availability') && is_array($availabilities = $request->input('availability', []))) {
        $query->where(function ($q) use ($availabilities) {
            if (in_array('in_stock', $availabilities)) {
                $q->orWhere(function ($q2) {
                    $q2->where('product_type', 'simple')
                       ->where('quantity', '>', 0);
                })->orWhereHas('variations', fn($qv) => $qv->where('quantity', '>', 0));
            }
            if (in_array('out_of_stock', $availabilities)) {
                $q->orWhere(function ($q2) {
                    $q2->where('product_type', 'simple')
                       ->where('quantity', '=', 0);
                })->orWhereHas('variations', fn($qv) => $qv->where('quantity', '=', 0));
            }
        });
    }

    // ... (các bộ lọc khác giữ nguyên)

    $products = $query->paginate(12);
    $categories = Category::withCount('products')->with('children')->where('is_active', true)->get();
    $colors = Color::all();
    $sizes = collect();
    foreach ($products as $product) {
        $sizes = $sizes->merge($product->variations->pluck('size')->filter());
    }
    $sizes = $sizes->unique('id')->values();
    $brands = Brand::where('is_active', true)->get();

    return view('client.products.index', compact('products', 'categories', 'colors', 'sizes', 'brands'));
}

    /**
     * Hiển thị chi tiết sản phẩm (client/products/show.blade.php)
     */
    public function show($slug)
    {
        $product = Product::with(['categories', 'brand', 'images', 'reviews.user', 'variations.color', 'variations.size', 'variations.images', 'variations.spherical', 'variations.cylindrical'])
            ->active()
            ->where('slug', $slug)
            ->firstOrFail();

        // Tăng lượt xem
        $product->increment('views');

        // Lấy các thuộc tính variations (fix: luôn lấy đủ option nếu có)
        $colors = $product->variations->pluck('color')->filter()->unique('id')->values();
        $sizes = $product->variations->pluck('size')->filter()->unique('id')->values();
        $sphericals = $product->variations->pluck('spherical')->filter()->unique('id')->values();
        $cylindricals = $product->variations->pluck('cylindrical')->filter()->unique('id')->values();

        // Tính toán $selectedVariation
        $selectedColorId = request()->input('variant', $product->variations->first()->color_id ?? null);
        $selectedSizeId = request()->input('size', $product->variations->first()->size_id ?? null);
        $selectedSphericalId = request()->input('spherical', $product->variations->first()->spherical_id ?? null);

        $selectedVariation = $product->variations
            ->where('color_id', $selectedColorId)
            ->when($selectedSizeId, fn($query) => $query->where('size_id', $selectedSizeId))
            ->when($selectedSphericalId, fn($query) => $query->where('spherical_id', $selectedSphericalId))
            ->first() ?? $product->variations->first();

        $activeColor = $selectedVariation ? ($selectedVariation->color->name ?? 'Blue') : 'Blue';
        $featuredImage = $selectedVariation && $selectedVariation->images->isNotEmpty()
            ? ($selectedVariation->images->where('is_featured', true)->first() ?? $selectedVariation->images->first())
            : ($product->images->where('is_featured', true)->first() ?? $product->images->first());

        $related_products = Product::with(['images', 'reviews', 'variations.color', 'variations.size'])
            ->active()
            ->where('id', '!=', $product->id)
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->take(4)
            ->get();

        // Prepare variationsJson for Blade (for JS)
        $variationsJson = $product->variations->map(function ($v) {
            return [
                'id' => $v->id,
                'color_id' => $v->color_id ? (string)$v->color_id : '',
                'size_id' => $v->size_id ? (string)$v->size_id : '',
                'spherical_id' => $v->spherical_id ? (string)$v->spherical_id : '',
                'cylindrical_id' => $v->cylindrical_id ? (string)$v->cylindrical_id : '',
                'image' => $v->images->first() ? asset('storage/' . $v->images->first()->image_path) : '',
                'price' => (float) $v->price,
                'sale_price' => (float) $v->sale_price,
                'quantity' => $v->quantity, // Đảm bảo có trường này
            ];
        })->values()->toArray();

        // Lấy bình luận (comments) cho sản phẩm, chỉ lấy bình luận đã duyệt
        $comments = $product->comments()->with('user')->where('status', 'đã duyệt')->orderByDesc('created_at')->get();

        return view('client.products.show', compact('product', 'related_products', 'selectedVariation', 'activeColor', 'featuredImage', 'colors', 'sizes', 'sphericals', 'cylindricals', 'variationsJson', 'comments'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng từ trang chi tiết sản phẩm
     */
    public function addToCart(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        return $this->errorResponse($request, 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!', 401);
    }

    $quantity = (int)$request->input('quantity', 1);
    if ($quantity <= 0) {
        return $this->errorResponse($request, 'Số lượng phải lớn hơn 0!', 400);
    }

    $variationId = $request->input('variation_id');
    $productId = $request->input('product_id');

    if ($variationId) {
        $variation = Variation::find($variationId);
        if (!$variation) {
            return $this->errorResponse($request, 'Không tìm thấy biến thể sản phẩm!', 404);
        }

        // Kiểm tra số lượng tồn kho
        if ($variation->quantity <= 0) {
            return $this->errorResponse($request, 'Sản phẩm này đã hết hàng!', 400);
        }

        $cartItem = Cart::where('user_id', $user->id)
            ->where('variation_id', $variationId)
            ->first();
        $currentQty = $cartItem ? $cartItem->quantity : 0;
        $totalQty = $currentQty + $quantity;

        if ($totalQty > $variation->quantity) {
            return $this->errorResponse($request, "Chỉ còn {$variation->quantity} sản phẩm trong kho!", 400);
        }

        if ($cartItem) {
            $cartItem->quantity = $totalQty;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'variation_id' => $variationId,
                'quantity' => $quantity,
            ]);
        }
        return $this->successResponse($request, 'Đã thêm sản phẩm vào giỏ hàng!');
    } elseif ($productId) {
        $product = Product::find($productId);
        if (!$product) {
            return $this->errorResponse($request, 'Không tìm thấy sản phẩm!', 404);
        }

        if ($product->product_type === 'variable') {
            return $this->errorResponse($request, 'Vui lòng chọn một biến thể cho sản phẩm này!', 400);
        }

        if ($product->quantity <= 0) {
            return $this->errorResponse($request, 'Sản phẩm này đã hết hàng!', 400);
        }

        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->whereNull('variation_id')
            ->first();
        $currentQty = $cartItem ? $cartItem->quantity : 0;
        $totalQty = $currentQty + $quantity;

        if ($totalQty > $product->quantity) {
            return $this->errorResponse($request, "Chỉ còn {$product->quantity} sản phẩm trong kho!", 400);
        }

        if ($cartItem) {
            $cartItem->quantity = $totalQty;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }
        return $this->successResponse($request, 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    return $this->errorResponse($request, 'Không xác định được sản phẩm cần thêm vào giỏ hàng!', 400);
}

private function errorResponse(Request $request, $message, $status)
{
    if ($request->ajax() || $request->expectsJson()) {
        return response()->json(['success' => false, 'message' => $message], $status);
    }
    return redirect()->back()->with('error', $message);
}

private function successResponse(Request $request, $message)
{
    if ($request->ajax()) {
        return response()->json(['success' => true, 'message' => $message]);
    }
    return redirect()->route('client.cart.index')->with('success', $message);
}
    public function comment(Request $request, $productId)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        // Kiểm tra nếu user đang bị cấm bình luận
        if ($user->banned_until && now()->lt($user->banned_until)) {
            return redirect()->back()->with('error', 'Bạn đã bị cấm bình luận đến ' . $user->banned_until->format('d/m/Y H:i'));
        }
        if ($user->status === 'bị chặn') {
            return redirect()->back()->with('error', 'Tài khoản của bạn đã bị chặn bình luận.');
        }

        $product = Product::findOrFail($productId);

        // Kiểm tra nếu user có bình luận nào bị chặn trong sản phẩm này hoặc toàn hệ thống
        $hasBlockedComment = $user->comments()->where('status', 'chặn')->exists();
        if ($hasBlockedComment) {
            // Cấm user bình luận 1 ngày kể từ bây giờ
            $user->banned_until = now()->addDay();
            $user->save();
            return redirect()->back()->with('error', 'Bạn đã bị cấm bình luận 1 ngày do có bình luận vi phạm.');
        }

        $product->comments()->create([
            'user_id' => $user->id,
            'content' => $request->input('content'),
            'status' => 'chờ duyệt',
        ]);

        return redirect()->back()->with('success', 'Bình luận của bạn đã được gửi và đang chờ duyệt!');
    }
}
