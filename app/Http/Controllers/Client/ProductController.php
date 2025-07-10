<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Color;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

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
            $minPriceRaw = $request->input('min_price', 0);
            $maxPriceRaw = $request->input('max_price', 999999999);
            $minPrice = preg_replace('/\D/', '', $minPriceRaw);
            $maxPrice = preg_replace('/\D/', '', $maxPriceRaw);
            $minPrice = (int) $minPrice;
            $maxPrice = (int) $maxPrice;


            $query->where(function ($q) use ($minPrice, $maxPrice) {
                // Sản phẩm thường
                $q->where(function ($q2) use ($minPrice, $maxPrice) {
                    $q2->where(function ($q3) use ($minPrice, $maxPrice) {
                        $q3->whereNotNull('price')
                            ->whereBetween('price', [$minPrice, $maxPrice]);
                    })
                        ->orWhere(function ($q3) use ($minPrice, $maxPrice) {
                            $q3->whereNotNull('sale_price')
                                ->whereBetween('sale_price', [$minPrice, $maxPrice]);
                        });
                });
                // Sản phẩm biến thể
                $q->orWhereHas('variations', function ($qv) use ($minPrice, $maxPrice) {
                    $qv->where(function ($q4) use ($minPrice, $maxPrice) {
                        $q4->whereNotNull('price')
                            ->whereBetween('price', [$minPrice, $maxPrice]);
                    })
                        ->orWhere(function ($q4) use ($minPrice, $maxPrice) {
                            $q4->whereNotNull('sale_price')
                                ->whereBetween('sale_price', [$minPrice, $maxPrice]);
                        });
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
        $search = $request->input('search') ?? $request->input('s');
        if (!empty($search)) {
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

        $products = $query->paginate(12);
        $categories = Category::withCount('products')->with('children')->where('is_active', true)->get();
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
                'price' => $v->price,
                'sale_price' => $v->sale_price,
                'stock_quantity' => $v->stock_quantity,
            ];
        })->values()->toArray();

        // Lấy bình luận (comments) cho sản phẩm, mới nhất trước(TA)
        $comments = $product->comments()->with('user')->orderByDesc('created_at')->get();

        return view('client.products.show', compact('product', 'related_products', 'selectedVariation', 'activeColor', 'featuredImage', 'colors', 'sizes', 'sphericals', 'cylindricals', 'variationsJson', 'comments'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng từ trang chi tiết sản phẩm
     */
    public function addToCart(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập!'], 401);
            }
            return redirect()->route('client.login')->with('error', 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!');
        }

        $quantity = $request->input('quantity', 1);
        $variationId = $request->input('variation_id');
        $productId = $request->input('product_id');

        if ($variationId) {
            $variation = \App\Models\Variation::find($variationId);
            if (!$variation) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Không tìm thấy biến thể sản phẩm!'], 404);
                }
                return back()->with('error', 'Không tìm thấy biến thể sản phẩm!');
            }
            if ($variation->stock_quantity < $quantity) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Số lượng sản phẩm không đủ trong kho!'], 400);
                }
                return back()->with('error', 'Số lượng sản phẩm không đủ trong kho!');
            }
            $cartItem = \App\Models\Cart::where('user_id', $user->id)
                ->where('variation_id', $variationId)
                ->first();
            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                \App\Models\Cart::create([
                    'user_id' => $user->id,
                    'variation_id' => $variationId,
                    'quantity' => $quantity,
                ]);
            }
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->route('client.cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
        } elseif ($productId) {
            $product = \App\Models\Product::find($productId);
            if (!$product) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Không tìm thấy sản phẩm!'], 404);
                }
                return back()->with('error', 'Không tìm thấy sản phẩm!');
            }
            if ($product->stock_quantity < $quantity) {
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Số lượng sản phẩm không đủ trong kho!'], 400);
                }
                return back()->with('error', 'Số lượng sản phẩm không đủ trong kho!');
            }
            $cartItem = \App\Models\Cart::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->whereNull('variation_id')
                ->first();
            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->save();
            } else {
                \App\Models\Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                ]);
            }
            if ($request->ajax()) {
                return response()->json(['success' => true]);
            }
            return redirect()->route('client.cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
        } else {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Không xác định được sản phẩm!'], 400);
            }
            return back()->with('error', 'Không xác định được sản phẩm cần thêm vào giỏ hàng!');
        }
    }
}