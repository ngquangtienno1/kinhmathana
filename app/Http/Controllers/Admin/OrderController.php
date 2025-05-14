<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Discount;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index()
    {
        $orders = Order::with(['user', 'items'])
            ->latest()
            ->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Hiển thị form tạo đơn hàng
     */
    public function create()
    {
        $users = User::all();
        $discounts = Discount::active()->get();
        return view('admin.orders.create', compact('users', 'discounts'));
    }

    /**
     * Lưu đơn hàng mới
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total_amount' => 'required|numeric',
            'discount_id' => 'nullable|exists:discounts,id',
            'payment_status' => 'required|in:pending,paid,failed,refunded,cancelled',
            'status' => 'required|in:pending,confirmed,processing,shipping,delivered,cancelled',
            'shipping_fee' => 'required|numeric',
            'note' => 'nullable|string',
            'shipping_address' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_phone' => 'required|string',
            'receiver_email' => 'nullable|email',
        ]);

        DB::beginTransaction();
        try {
            $order = Order::create($data);

            // Tạo log trạng thái đầu tiên
            $order->orderStatusLogs()->create([
                'status' => $data['status'],
                'note' => 'Đơn hàng được tạo'
            ]);

            DB::commit();
            return redirect()
                ->route('admin.orders.show', $order)
                ->with('success', 'Tạo đơn hàng thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Có lỗi xảy ra khi tạo đơn hàng')
                ->withInput();
        }
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function show(Order $order)
    {
        $order->load(['user']);
        return view('admin.orders.detail', compact('order'));
    }

    /**
     * Hiển thị form chỉnh sửa đơn hàng
     */
    public function edit(Order $order)
    {
        $users = User::all();
        $discounts = Discount::active()->get();
        return view('admin.orders.edit', compact('order', 'users', 'discounts'));
    }

    /**
     * Cập nhật thông tin đơn hàng
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'total_amount' => 'required|numeric',
            'discount_id' => 'nullable|exists:discounts,id',
            'payment_status' => 'required|in:pending,paid,failed,refunded,cancelled',
            'status' => 'required|in:pending,confirmed,processing,shipping,delivered,cancelled',
            'shipping_fee' => 'required|numeric',
            'note' => 'nullable|string',
            'shipping_address' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_phone' => 'required|string',
            'receiver_email' => 'nullable|email',
        ]);

        DB::beginTransaction();
        try {
            $order->update($data);

            // Nếu trạng thái thay đổi, tạo log mới
            if ($order->isDirty('status')) {
                $order->orderStatusLogs()->create([
                    'status' => $data['status'],
                    'note' => 'Cập nhật trạng thái đơn hàng'
                ]);
            }

            DB::commit();
            return redirect()
                ->route('admin.orders.show', $order)
                ->with('success', 'Cập nhật đơn hàng thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Có lỗi xảy ra khi cập nhật đơn hàng')
                ->withInput();
        }
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,awaiting_payment,confirmed,processing,shipping,delivered,returned,processing_return,refunded',
            'comment' => 'nullable|string'
        ]);

        DB::transaction(function () use ($order, $request) {
            $oldStatus = $order->status;
            $order->update([
                'status' => $request->status,
                'admin_note' => $request->comment
            ]);

            // Cập nhật thời gian tương ứng với trạng thái
            if ($request->status === 'confirmed' && !$order->confirmed_at) {
                $order->update(['confirmed_at' => now()]);
            } elseif ($request->status === 'delivered' && !$order->completed_at) {
                $order->update(['completed_at' => now()]);
            }

            // Lưu lịch sử
            $order->histories()->create([
                // 'user_id' => auth()->id(),
                'status_from' => $oldStatus,
                'status_to' => $request->status,
                'comment' => $request->comment
            ]);
        });

        return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
    }

    /**
     * Cập nhật trạng thái thanh toán đơn hàng
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed,refunded,cancelled,partially_paid,disputed',
            'comment' => 'nullable|string'
        ]);

        DB::transaction(function () use ($order, $request) {
            $oldPaymentStatus = $order->payment_status;
            $order->update([
                'payment_status' => $request->payment_status,
                'admin_note' => $request->comment
            ]);

            // Lưu lịch sử
            $order->histories()->create([
                // 'user_id' => auth()->id(),
                'payment_status_from' => $oldPaymentStatus,
                'payment_status_to' => $request->payment_status,
                'comment' => $request->comment
            ]);
        });

        return back()->with('success', 'Cập nhật trạng thái thanh toán thành công');
    }

    /**
     * Xóa đơn hàng
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return redirect()
                ->route('admin.orders.index')
                ->with('success', 'Xóa đơn hàng thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa đơn hàng');
        }
    }
}