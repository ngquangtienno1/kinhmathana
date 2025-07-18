<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Xem danh sách wishlist
    public function index()
    {
        $user = Auth::user();
        $wishlists = Wishlist::with('product.images')->where('user_id', $user->id)->get();
        return view('client.products.wishlist', compact('wishlists'));
    }

    // Thêm vào wishlist
    public function addToWishlist(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần đăng nhập!');
        }
        $productId = $request->input('product_id');
        if (!$productId || !Product::find($productId)) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại!');
        }
        $exists = Wishlist::where('user_id', $user->id)->where('product_id', $productId)->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Sản phẩm đã có trong yêu thích!');
        }
        Wishlist::create(['user_id' => $user->id, 'product_id' => $productId]);
        return redirect()->back()->with('success', 'Đã thêm vào yêu thích!');
    }

    // Xóa khỏi wishlist
    public function removeFromWishlist(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('client.login')->with('error', 'Bạn cần đăng nhập!');
        }
        $productId = $request->input('product_id');
        Wishlist::where('user_id', $user->id)->where('product_id', $productId)->delete();
        return redirect()->back()->with('success', 'Đã xóa khỏi yêu thích!');
    }
} 