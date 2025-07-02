<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Hiển thị danh sách sản phẩm dạng lưới (client/products/index.blade.php)
     */
    public function index(Request $request)
    {
        $query = Product::with(['categories', 'brand', 'images', 'variations.color'])
            ->active();

        // Bộ lọc: Availability
        if ($request->has('availability') && is_array($availabilities = $request->input('availability', []))) {
            $query->where(function ($q) use ($availabilities) {
                if (in_array('in_stock', $availabilities)) {
                    $q->orWhere('stock_quantity', '>', 0)
                      ->orWhereHas('variations', fn($qv) => $qv->where('stock_quantity', '>', 0));
                }
                if (in_array('out_of_stock', $availabilities)) {
                    $q->orWhere('stock_quantity', '=', 0)
                      ->orWhereHas('variations', fn($qv) => $qv->where('stock_quantity', '=', 0));
                }
            });
        }

        // Bộ lọc: Color
        if ($request->has('colors') && is_array($colors = $request->input('colors', []))) {
            $query->whereHas('variations.color', function ($q) use ($colors) {
                $q->whereIn('colors.id', $colors);
            });
        }

        // Bộ lọc: Brands
        if ($request->has('brands') && is_array($brands = $request->input('brands', []))) {
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
        if ($request->filled('rating')) {
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

        $orderby = $request->input('orderby', 'menu_order');
    switch ($orderby) {
        case 'popularity':
            $query->withCount('orderItems')->orderBy('order_items_count', 'desc');
            break;
        case 'rating':
            $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
            break;
        case 'date':
            $query->orderBy('created_at', 'desc');
            break;
        case 'price':
            $query->orderBy('price', 'asc');
            break;
        case 'price-desc':
            $query->orderBy('price', 'desc');
            break;
        default:
            $query->orderBy('id', 'asc');
            break;
    }

    // Phân trang
    $products = $query->paginate(6); // 6 sản phẩm mỗi trang
    $categories = Category::with('children')->where('is_active', true)->get();
    $colors = Color::all();
    $brands = Brand::where('is_active', true)->get();

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

        return view('client.products.show', compact('product', 'related_products', 'selectedVariation', 'activeColor', 'featuredImage'));
    }
}
