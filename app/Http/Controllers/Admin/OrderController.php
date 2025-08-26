<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Discount;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\OrderPlaced;
use App\Mail\OrderDelivered;
use App\Mail\OrderDeliveryFailed;
use App\Http\Controllers\Admin\NotificationController;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Kiểm tra xem phương thức thanh toán có phải là COD không
     */
    private function isCodPayment(Order $order): bool
    {
        return $order->paymentMethod && $order->paymentMethod->code === 'cod';
    }

    /**
     * Kiểm tra xem phương thức thanh toán có phải là online không
     */
    private function isOnlinePayment(Order $order): bool
    {
        return $order->paymentMethod && in_array($order->paymentMethod->code, ['vnpay', 'momo', 'banking', 'card',]);
    }

    /**
     * Cập nhật trạng thái thanh toán dựa trên trạng thái đơn hàng
     */
    private function updatePaymentStatusBasedOnOrderStatus(Order $order, string $newStatus): void
    {
        $paymentStatus = $order->payment_status;
        $isCod = $this->isCodPayment($order);
        $isOnline = $this->isOnlinePayment($order);

        switch ($newStatus) {
            case 'confirmed':
                // Nếu là online payment, tự động cập nhật thành paid
                if ($isOnline) {
                    $paymentStatus = 'paid';
                }
                break;

            case 'shipping':
                // Nếu là COD, giữ nguyên unpaid
                if ($isCod) {
                    $paymentStatus = 'unpaid';
                }
                break;

            case 'delivered':
                // Nếu là COD, cập nhật thành paid
                if ($isCod && $paymentStatus === 'unpaid') {
                    $paymentStatus = 'paid';
                }
                break;

            case 'completed':
                // Giữ nguyên trạng thái thanh toán nếu đã delivered và thanh toán xong
                if ($order->status === 'delivered' && $paymentStatus === 'paid') {
                    // Không thay đổi payment_status
                }
                break;

            case 'cancelled_by_customer':
            case 'cancelled_by_admin':
                // Nếu là online và chưa thanh toán, cập nhật thành failed
                if ($isOnline && $paymentStatus === 'unpaid') {
                    $paymentStatus = 'failed';
                }
                break;

            case 'delivery_failed':
                // Nếu là COD, giữ nguyên unpaid
                // Nếu là online, cập nhật thành failed
                if ($isOnline) {
                    $paymentStatus = 'failed';
                } else if ($isCod) {
                    $paymentStatus = 'unpaid';
                }
                break;
        }

        if ($paymentStatus !== $order->payment_status) {
            Log::info('Updating payment status', [
                'order_id' => $order->id,
                'old_payment_status' => $order->payment_status,
                'new_payment_status' => $paymentStatus,
                'order_status' => $newStatus,
                'payment_method' => $order->paymentMethod ? $order->paymentMethod->code : 'unknown',
                'is_cod' => $isCod,
                'is_online' => $isOnline
            ]);

            $order->update(['payment_status' => $paymentStatus]);
        }
    }

    /**
     * Hiển thị danh sách đơn hàng
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items', 'paymentMethod', 'shippingProvider'])
            ->latest();

        // Tìm kiếm theo mã đơn hàng hoặc tên khách hàng
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('receiver_name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Lọc theo trạng thái thanh toán
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        // Lọc theo trạng thái đơn hàng
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();
        // Đếm số lượng các trạng thái
        $countAll = Order::count();
        $countPending = Order::where('status', 'pending')->count();
        $countShipping = Order::where('status', 'shipping')->count();
        $countDelivered = Order::where('status', 'delivered')->count();
        $countCancelled = Order::where('status', 'cancelled')->count();
        $countCancelledByCustomer = Order::where('status', 'cancelled_by_customer')->count();
        $countCancelledByAdmin = Order::where('status', 'cancelled_by_admin')->count();
        return view('admin.orders.index', compact(
            'orders',
            'countAll',
            'countPending',
            'countShipping',
            'countDelivered',
            'countCancelled',
            'countCancelledByCustomer',
            'countCancelledByAdmin'
        ));
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
            'payment_status' => 'required|in:unpaid,paid,failed',
            'status' => 'required|in:pending,confirmed,awaiting_pickup,shipping,delivered,completed,cancelled_by_customer,cancelled_by_admin,delivery_failed',
            'shipping_fee' => 'required|numeric',
            'note' => 'nullable|string',
            'shipping_address' => 'required|string',
            'receiver_name' => 'required|string',
            'receiver_phone' => 'required|string',
            'receiver_email' => 'nullable|email',
        ]);

        DB::beginTransaction();
        try {
            // Lấy thông tin phương thức thanh toán
            $codPaymentMethod = PaymentMethod::where('code', 'cod')->first();

            // Nếu phương thức thanh toán là COD, đặt trạng thái thanh toán và đơn hàng mặc định
            if ($codPaymentMethod && $request->input('payment_method_id') == $codPaymentMethod->id) {
                $data['payment_status'] = 'unpaid';
                $data['status'] = 'pending';
            }

            $order = Order::create($data);

            // Tạo log trạng thái đầu tiên
            $order->orderStatusLogs()->create([
                'status' => $data['status'],
                'note' => 'Đơn hàng được tạo'
            ]);

            DB::commit();

            // Gửi email xác nhận đơn hàng sau khi commit
            try {
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(new OrderPlaced($order));
                } elseif ($order->customer_email) {
                    Mail::to($order->customer_email)->send(new OrderPlaced($order));
                }
            } catch (\Exception $e) {
                Log::error('Lỗi gửi mail OrderPlaced: ' . $e->getMessage());
            }
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
        $order->load(['user', 'promotion', 'paymentMethod', 'shippingProvider']);
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
            'payment_status' => 'required|in:unpaid,paid,failed',
            'status' => 'required|in:pending,confirmed,awaiting_pickup,shipping,delivered,completed,cancelled_by_customer,cancelled_by_admin,delivery_failed',
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
            'status' => 'required|in:pending,confirmed,awaiting_pickup,shipping,delivered,completed,cancelled_by_admin,delivery_failed',
            'comment' => 'nullable|string',
            'cancellation_reason_id' => 'nullable',
        ]);

        // Kiểm tra nếu đơn hàng đã bị khách hủy thì không cho phép cập nhật
        if ($order->status === 'cancelled_by_customer') {
            return back()->with('error', 'Không thể cập nhật trạng thái đơn hàng đã bị khách hủy');
        }

        // Kiểm tra cấu hình mail trước khi cho phép cập nhật trạng thái cần gửi thông báo
        if (in_array($request->status, ['delivered', 'delivery_failed'])) {
            // Test gửi mail thực tế trước khi cho phép cập nhật
            $testEmail = $order->user ? $order->user->email : $order->customer_email;
            if ($testEmail) {
                try {
                    // Test gửi mail với nội dung rỗng để kiểm tra kết nối
                    Mail::raw('', function ($message) use ($testEmail) {
                        $message->to($testEmail)->subject('Test Connection');
                    });
                } catch (\Exception $e) {
                    return back()->with('error', 'Không thể gửi email thông báo do chưa cấu hình hệ thống gửi mail. Vui lòng kiểm tra cấu hình email để đảm bảo thông báo đơn hàng được gửi đến khách hàng.');
                }
            }
        }

        DB::transaction(function () use ($order, $request) {
            $oldStatus = $order->status;
            $updateData = [
                'status' => $request->status,
                'admin_note' => $request->comment,
            ];

            // Xử lý khi admin hủy đơn
            if ($request->status === 'cancelled_by_admin') {
                if (!$request->cancellation_reason_id) {
                    throw new \Exception('Vui lòng chọn lý do huỷ đơn hàng!');
                }
                if (str_starts_with($request->cancellation_reason_id, 'other:')) {
                    $newReason = trim(substr($request->cancellation_reason_id, 6));
                    $reason = \App\Models\CancellationReason::create([
                        'reason' => $newReason,
                        'type' => 'admin',
                        'is_active' => true,
                    ]);
                    $updateData['cancellation_reason_id'] = $reason->id;
                } else {
                    $updateData['cancellation_reason_id'] = $request->cancellation_reason_id;
                }
                $updateData['cancelled_at'] = now();

                // Gửi thông báo khi admin hủy đơn
                $reason = \App\Models\CancellationReason::find($updateData['cancellation_reason_id']);
                $reasonText = $reason ? $reason->reason : 'Không có lý do';
                app(NotificationController::class)->notifyOrderCancelled($order->id, $reasonText, 'Admin');
            } else {
                $updateData['cancellation_reason_id'] = null;
            }

            $order->update($updateData);

            // Khi admin huỷ đơn, hoàn lại tồn kho (chỉ thực hiện nếu trước đó đơn chưa ở trạng thái huỷ)
            if (
                $request->status === 'cancelled_by_admin' &&
                !in_array($oldStatus, ['cancelled_by_admin', 'cancelled_by_customer'])
            ) {
                foreach ($order->items as $item) {
                    if ($item->variation_id) {
                        $variation = \App\Models\Variation::find($item->variation_id);
                        if ($variation) {
                            $variation->quantity = ($variation->quantity ?? 0) + $item->quantity;
                            $variation->save();
                        }
                    } else if ($item->product_id) {
                        $product = \App\Models\Product::find($item->product_id);
                        if ($product) {
                            $product->quantity = ($product->quantity ?? 0) + $item->quantity;
                            $product->save();
                        }
                    }
                }
            }

            // Khi đơn hàng bị giao thất bại, hoàn lại tồn kho (chỉ thực hiện nếu trước đó đơn chưa ở trạng thái giao thất bại)
            if (
                $request->status === 'delivery_failed' &&
                $oldStatus !== 'delivery_failed'
            ) {
                foreach ($order->items as $item) {
                    if ($item->variation_id) {
                        $variation = \App\Models\Variation::find($item->variation_id);
                        if ($variation) {
                            $variation->quantity = ($variation->quantity ?? 0) + $item->quantity;
                            $variation->save();
                        }
                    } else if ($item->product_id) {
                        $product = \App\Models\Product::find($item->product_id);
                        if ($product) {
                            $product->quantity = ($product->quantity ?? 0) + $item->quantity;
                            $product->save();
                        }
                    }
                }
            }

            // Cập nhật trạng thái thanh toán dựa trên trạng thái đơn hàng mới
            $this->updatePaymentStatusBasedOnOrderStatus($order, $request->status);

            // Cập nhật thời gian tương ứng với trạng thái
            if ($request->status === 'confirmed' && !$order->confirmed_at) {
                $order->update(['confirmed_at' => now()]);
            } elseif ($request->status === 'delivered' && !$order->completed_at) {
                $order->update(['completed_at' => now()]);

                // Gửi email khi đơn hàng được giao thành công
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(new OrderDelivered($order));
                } elseif ($order->customer_email) {
                    Mail::to($order->customer_email)->send(new OrderDelivered($order));
                }
            } elseif ($request->status === 'completed' && !$order->completed_at) {
                $order->update(['completed_at' => now()]);
            } elseif ($request->status === 'delivery_failed') {
                // Gửi email khi giao hàng thất bại
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(new OrderDeliveryFailed($order));
                } elseif ($order->customer_email) {
                    Mail::to($order->customer_email)->send(new OrderDeliveryFailed($order));
                }
            }

            // Lưu lịch sử
            $order->histories()->create([
                'status_from' => $oldStatus,
                'status_to' => $request->status,
                'comment' => $request->comment
            ]);

            // Lưu lịch sử trạng thái
            $order->statusHistories()->create([
                'old_status' => $oldStatus,
                'new_status' => $request->status,
                'note' => $request->comment,
                'updated_by' => Auth::id()
            ]);
        });

        // Thông báo khác nhau tùy theo trạng thái
        if ($request->status === 'delivered') {
            return back()->with('success', 'Đã gửi thông báo đơn hàng đến khách hàng. Cập nhật trạng thái đơn hàng thành công');
        } else {
            return back()->with('success', 'Cập nhật trạng thái đơn hàng thành công');
        }
    }



    /**
     * Xóa đơn hàng
     */
    public function destroy(Order $order)
    {
        // Kiểm tra xem đơn hàng có ở trạng thái đã hủy không
        if (!in_array($order->status, ['cancelled_by_customer', 'cancelled_by_admin'])) {
            return back()->with('error', 'Chỉ có thể xóa đơn hàng đã hủy');
        }

        try {
            $order->delete();

            return redirect()
                ->route('admin.orders.index')
                ->with('success', 'Xóa đơn hàng thành công');
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi xóa đơn hàng');
        }
    }

    /**
     * In đơn hàng (view đẹp cho in)
     */
    public function print(Order $order)
    {
        $order->load(['user', 'promotion', 'paymentMethod', 'shippingProvider', 'items']);
        return view('admin.orders.print', compact('order'));
    }
}
