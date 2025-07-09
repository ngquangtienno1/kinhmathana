<?php

namespace App\Http\Controllers\Client;

use App\Models\Slider;
use App\Models\Product;
<<<<<<< HEAD
=======
use App\Models\News;
use App\Models\Slider;
>>>>>>> ce4619afef8fe10330eb72b65c620d23fcc043f0
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\News;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)
<<<<<<< HEAD
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

        $cartCount = 0;
        if (session()->has('cart')) {
            $cart = session('cart');
            $cartCount = collect($cart)->sum('quantity');
        }

        return view('client.home', compact('sliders', 'featuredProducts', 'latestNews', 'cartCount'));
=======
            ->orderBy('sort_order', 'asc')
            ->get();
            
        return view('client.home', compact('sliders'));
>>>>>>> ce4619afef8fe10330eb72b65c620d23fcc043f0
    }
}
