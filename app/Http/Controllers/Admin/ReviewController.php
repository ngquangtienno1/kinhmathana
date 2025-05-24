<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|between:1,5',
            'content' => 'required|string|min:10',
        ]);

        $userId = Auth::id();
        $order = Order::findOrFail($request->order_id);

        // Kiểm tra đơn hàng có thuộc về người dùng không
        if ($order->user_id !== $userId) {
            return back()->with('error', 'Bạn không có quyền đánh giá sản phẩm trong đơn hàng này.');
        }

        // Kiểm tra đơn hàng đã giao thành công chưa
        if ($order->status !== 'delivered') {
            return back()->with('error', 'Bạn chỉ có thể đánh giá sản phẩm sau khi đơn hàng được giao thành công.');
        }

        // Kiểm tra sản phẩm có trong đơn hàng không
        $productInOrder = $order->items()->where('product_id', $request->product_id)->exists();
        if (!$productInOrder) {
            return back()->with('error', 'Sản phẩm này không có trong đơn hàng của bạn.');
        }

        // Kiểm tra đã đánh giá chưa
        $existingReview = Review::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id)
            ->exists();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này trong đơn hàng.');
        }

        Review::create([
            'user_id' => $userId,
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Đánh giá sản phẩm thành công');
    }

    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('content', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $reviews = $query->get();
        
        return view('admin.reviews.index', compact('reviews'));
    }

    public function show($id)
    {
        $review = Review::with(['user', 'product', 'order'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        
        return redirect()->route('admin.reviews.index')
            ->with('success', 'Đã xóa đánh giá thành công');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        Review::whereIn('id', $ids)->delete();
        
        return response()->json(['success' => 'Đã xóa các đánh giá đã chọn']);
    }

    public function userCanReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
        ]);

        $canReview = Review::canReview(
            Auth::id(),
            $request->product_id,
            $request->order_id
        );

        return response()->json(['can_review' => $canReview]);
    }
} 