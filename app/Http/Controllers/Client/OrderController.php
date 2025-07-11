<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Review;
use App\Models\ReviewImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $status = $request->get('status');
        $q = $request->get('q');
        $query = Order::with(['items.product.images'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at');
        if ($status) {
            if ($status === 'cancelled') {
                $query->whereIn('status', ['cancelled_by_customer', 'cancelled_by_admin']);
            } else {
                $query->where('status', $status);
            }
        }
        // Bổ sung tìm kiếm theo mã đơn hàng hoặc tên sản phẩm
        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('order_number', 'like', "%$q%")
                    ->orWhereHas('items', function($q2) use ($q) {
                        $q2->where('product_name', 'like', "%$q%")
                            ->orWhereHas('product', function($q3) use ($q) {
                                $q3->where('name', 'like', "%$q%")
                                    ->orWhere('slug', 'like', "%$q%")
                                    ;
                            });
                    });
            });
        }
        $orders = $query->paginate(10);
        return view('client.orders.index', compact('orders', 'status'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $order = Order::with(['items.product.images', 'paymentMethod'])->where('user_id', $user->id)->findOrFail($id);
        return view('client.orders.show', compact('order'));
    }

    public function cancel(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Đơn hàng đã được duyệt hoặc thay đổi trạng thái, không thể hủy.']);
        }

        $reasonId = $request->input('cancellation_reason_id');
        if (!$reasonId) {
            return response()->json(['success' => false, 'message' => 'Vui lòng chọn lý do hủy đơn hàng!']);
        }

        if (str_starts_with($reasonId, 'other:')) {
            $newReason = trim(substr($reasonId, 6));
            if (!$newReason) {
                return response()->json(['success' => false, 'message' => 'Vui lòng nhập lý do hủy mới!']);
            }
            $order->cancellation_reason_id = null;
            $order->cancellation_reason_text = $newReason;
        } else {
            $order->cancellation_reason_id = $reasonId;
            $order->cancellation_reason_text = null;
        }

        $order->status = 'cancelled_by_customer';
        $order->cancelled_at = now();
        $order->save();

        return response()->json(['success' => true]);
    }

    public function reviewForm($orderId, $itemId)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->whereIn('status', ['delivered', 'completed'])
            ->findOrFail($orderId);
        $item = $order->items()->findOrFail($itemId);
        $reviewed = Review::where('user_id', $user->id)
            ->where('product_id', $item->product_id)
            ->where('order_id', $order->id)
            ->exists();
        if ($reviewed) {
            return redirect()->route('client.orders.show', $order->id)->with('error', 'Bạn đã đánh giá sản phẩm này!');
        }
        return view('client.orders.review', compact('order', 'item'));
    }

    public function submitReview(Request $request, $orderId, $itemId)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->whereIn('status', ['delivered', 'completed'])
            ->findOrFail($orderId);
        $item = $order->items()->findOrFail($itemId);
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|max:1000',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'video' => 'nullable|file|mimes:mp4,webm,ogg|max:51200',
        ]);
        $reviewed = Review::where('user_id', $user->id)
            ->where('product_id', $item->product_id)
            ->where('order_id', $order->id)
            ->exists();
        if ($reviewed) {
            return redirect()->route('client.orders.show', $order->id)->with('error', 'Bạn đã đánh giá sản phẩm này!');
        }
        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $item->product_id,
            'order_id' => $order->id,
            'content' => $request->content,
            'rating' => $request->rating,
        ]);
        // Lưu ảnh
        Log::info('Review upload images:', [
            'hasFile' => $request->hasFile('images'),
            'files' => $request->file('images'),
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $path = $image->store('review_images', 'public');
                    ReviewImage::create([
                        'review_id' => $review->id,
                        'image_path' => $path,
                    ]);
                }
            }
        }
        // Lưu video (nếu muốn lưu vào bảng review_images, dùng cột video_path, nếu có bảng riêng thì tạo mới)
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            if ($video->isValid()) {
                $path = $video->store('review_videos', 'public');
                // Nếu bảng review_images có cột video_path:
                ReviewImage::create([
                    'review_id' => $review->id,
                    'image_path' => null,
                    'video_path' => $path,
                ]);
                // Nếu dùng bảng riêng, hãy tạo bản ghi ở bảng review_videos
            }
        }
        return redirect()->route('client.orders.show', $order->id)->with('success', 'Đánh giá thành công!');
    }

    /**
     * Xác nhận đã nhận hàng
     */
    public function confirmReceived($id)
    {
        $user = Auth::user();
        $order = Order::where('user_id', $user->id)
            ->where('status', 'delivered')
            ->findOrFail($id);

        // Cập nhật trạng thái đơn hàng
        $order->status = 'completed';
        $order->completed_at = now();
        $order->save();

        // Lưu lịch sử trạng thái
        $order->statusHistories()->create([
            'old_status' => 'delivered',
            'new_status' => 'completed',
            'note' => 'Khách hàng xác nhận đã nhận hàng',
            'updated_by' => $user->id
        ]);

        // Lưu lịch sử
        $order->histories()->create([
            'status_from' => 'delivered',
            'status_to' => 'completed',
            'comment' => 'Khách hàng xác nhận đã nhận hàng'
        ]);

        return redirect()->route('client.orders.show', $order->id)
            ->with('success', 'Đã xác nhận nhận hàng thành công! Bây giờ bạn có thể đánh giá sản phẩm.');
    }
}