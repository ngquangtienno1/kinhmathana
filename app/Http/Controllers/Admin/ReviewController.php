<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Product;
use App\Models\User;

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
        $query = Review::query();

        // Tìm kiếm theo nội dung, tên người dùng, email người dùng, tên sản phẩm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(content) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                            ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($search) . '%']);
                    })
                    ->orWhereHas('product', function ($q) use ($search) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%']);
                    });
            });
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by reply status
        if ($request->filled('reply_status')) {
            if ($request->reply_status === 'replied') {
                $query->whereNotNull('reply');
            } elseif ($request->reply_status === 'not_replied') {
                $query->whereNull('reply');
            }
        }

        // Filter by date range (created_at)
        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }

        $sort = $request->get('sort', 'id');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);

        $reviews = $query->get();

        // Count reviews by rating (for filter dropdown)
        $oneStarCount = Review::where('rating', 1)->count();
        $twoStarCount = Review::where('rating', 2)->count();
        $threeStarCount = Review::where('rating', 3)->count();
        $fourStarCount = Review::where('rating', 4)->count();
        $fiveStarCount = Review::where('rating', 5)->count();

        // Count reviews by reply status (for filter dropdown)
        $repliedCount = Review::whereNotNull('reply')->count();
        $notRepliedCount = Review::whereNull('reply')->count();

        // Get lists for product and user filters
        $products = Product::select('id', 'name')->orderBy('name')->get();
        $users = User::select('id', 'name', 'email')->orderBy('name')->get();

        return view('admin.reviews.index', compact('reviews', 'oneStarCount', 'twoStarCount', 'threeStarCount', 'fourStarCount', 'fiveStarCount', 'repliedCount', 'notRepliedCount', 'products', 'users'));
    }

    public function show($id)
    {
        $review = Review::with(['user', 'product', 'order'])->findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    public function destroy(Request $request, $id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        $redirect = $request->input('redirect');
        if ($redirect) {
            return redirect($redirect)->with('success', 'Xoá đánh giá thành công!');
        }
        return redirect()->route('admin.reviews.index')->with('success', 'Xoá đánh giá thành công!');
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

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }
        if (empty($ids) || count($ids) === 0) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một đánh giá để xóa.');
        }
        try {
            Review::whereIn('id', $ids)->delete();
            return redirect()->route('admin.reviews.index')->with('success', 'Đã xóa mềm các đánh giá đã chọn!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi xóa: ' . $e->getMessage());
        }
    }

    // Method to handle admin reply to a review
    public function reply(Request $request, Review $review)
    {
        $validator = Validator::make($request->all(), [
            'reply' => 'required|string|min:1',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $review->reply = $request->reply;
        $review->updated_at = now();
        $review->save();

        return back()->with('success', 'Đã trả lời đánh giá thành công!');
    }

    public function toggleVisibility($id, Request $request)
    {
        $review = Review::findOrFail($id);
        $review->is_hidden = (bool) $request->input('is_hidden');
        $review->save();

        return back()->with('success', 'Cập nhật trạng thái đánh giá thành công!');
    }
}
