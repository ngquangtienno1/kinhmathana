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

        if (!Review::canReview($userId, $request->product_id, $request->order_id)) {
            return back()->with('error', 'Bạn không thể đánh giá sản phẩm này. Có thể bạn chưa mua sản phẩm, đơn hàng chưa hoàn thành hoặc đã đánh giá rồi.');
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