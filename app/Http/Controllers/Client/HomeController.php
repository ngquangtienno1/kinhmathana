<?php

namespace App\Http\Controllers\Client;

use App\Models\Slider;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)
            ->get();

        $featuredProducts = Product::with(['images', 'categories', 'brand', 'variations.color'])
            ->active()
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $latestNews = News::with(['category', 'author'])
            ->active()
            ->published()
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        // Lấy sản phẩm bán chạy nhất (best sellers)
        $bestSellerProducts = Product::with(['images', 'categories', 'brand', 'variations.color', 'variations.images'])
            ->active()
            ->withSum('orderItems as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->limit(6)
            ->get();

        $cartCount = 0;
        if (session()->has('cart')) {
            $cart = session('cart');
            $cartCount = collect($cart)->sum('quantity');
        }

        return view('client.home', compact('sliders', 'featuredProducts', 'latestNews', 'cartCount', 'bestSellerProducts'));
    }
}