<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Review;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm dạng lưới (client/products/index.blade.php)
     */
    public function index(Request $request)
    {
        $query = Product::with(['categories', 'brand', 'images', 'reviews', 'variations.color', 'variations.size', 'variations.images'])
            ->active();

        // Bộ lọc: Availability
        if ($request->has('availability')) {
            $availabilities = $request->input('availability', []);
            $query->where(function ($q) use ($availabilities) {
                if (in_array('in_stock', $availabilities)) {
                    $q->orWhere('stock_quantity', '>', 0);
                }
                if (in_array('out_of_stock', $availabilities)) {
                    $q->orWhere('stock_quantity', '=', 0);
                }
            });
        }

        // Bộ lọc: Color
        if ($request->has('colors')) {
            $colors = $request->input('colors', []);
            $query->whereHas('variations.color', function ($q) use ($colors) {
                $q->whereIn('colors.id', $colors);
            });
        }

        // Bộ lọc: Brands
        if ($request->has('brands')) {
            $brands = $request->input('brands', []);
            $query->whereIn('brand_id', $brands);
        }

        // Bộ lọc: Price range
        if ($request->filled('min_price') || $request->filled('max_price')) {
            $minPrice = $request->input('min_price', 0);
            $maxPrice = $request->input('max_price', 999999);
            $query->where(function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('sale_price', [$minPrice, $maxPrice])
                    ->orWhereBetween('price', [$minPrice, $maxPrice])
                    ->orWhereHas('variations', function ($qv) use ($minPrice, $maxPrice) {
                        $qv->whereBetween('sale_price', [$minPrice, $maxPrice])
                            ->orWhereBetween('price', [$minPrice, $maxPrice]);
                    });
            });
        }

        // Bộ lọc: Rating
        if ($request->has('rating')) {
            $rating = $request->input('rating');
            $query->whereHas('reviews', function ($q) use ($rating) {
                $q->havingRaw('AVG(rating) >= ?', [$rating]);
            }, '>=', 1);
        }

        // Bộ lọc: Category
        if ($request->filled('category_id')) {
            $categoryId = $request->input('category_id');
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Phân trang
        $products = $query->orderBy('created_at', 'desc')->paginate(12);
        $categories = Category::all();
        $colors = Color::all();
        $brands = Brand::all();

        return view('client.products.index', compact('products', 'categories', 'colors', 'brands'));
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

        // Tính toán $selectedVariation
        $selectedColorId = request()->has('variant') ? request()->input('variant') : ($product->variations->first()->color_id ?? null);
        $selectedSizeId = request()->has('size') ? request()->input('size') : ($product->variations->first()->size_id ?? null);
        $selectedSphericalId = request()->has('spherical') ? request()->input('spherical') : ($product->variations->first()->spherical_id ?? null);

        $selectedVariation = $product->variations
            ->where('color_id', $selectedColorId)
            ->when($selectedSizeId, fn($query) => $query->where('size_id', $selectedSizeId))
            ->when($selectedSphericalId, fn($query) => $query->where('spherical_id', $selectedSphericalId))
            ->first() ?? $product->variations->first();

        $activeColor = $selectedVariation ? ($selectedVariation->color->name ?? 'Blue') : 'Blue';
        $featuredImage = $selectedVariation && $selectedVariation->images ? $selectedVariation->images->where('is_featured', true)->first() : ($product->images->where('is_featured', true)->first() ?? null);

        $related_products = Product::with(['images', 'reviews', 'variations.color', 'variations.size', 'variations.spherical', 'variations.cylindrical'])
            ->active()
            ->where('id', '!=', $product->id)
            ->whereHas('categories', function ($q) use ($product) {
                $q->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->take(4)
            ->get();

        return view('client.products.detail', compact('product', 'related_products', 'selectedVariation', 'activeColor', 'featuredImage'));
    }
    public function addToWishlist($productId)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Vui lòng đăng nhập'], 401);
        }

        $exists = Wishlist::where('user_id', $user->id)->where('product_id', $productId)->exists();
        if ($exists) {
            Wishlist::where('user_id', $user->id)->where('product_id', $productId)->delete();
            return response()->json(['success' => 'Đã xóa khỏi danh sách yêu thích']);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId,
        ]);

        return response()->json(['success' => 'Đã thêm vào danh sách yêu thích']);
    }

    public function storeReview(Request $request, $slug)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá');
        }

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'description' => 'required|string|max:1000',
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();

        Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $request->rating,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được gửi!');
    }
}
