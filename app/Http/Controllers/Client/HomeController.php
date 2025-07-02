<?php

namespace App\Http\Controllers\Client;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->orderBy('sort_order', 'asc')
            ->take(6)
            ->get();
        
        // Debug để kiểm tra dữ liệu
        // dd($sliders->toArray());
        
        return view('client.home', compact('sliders'));
    }
}