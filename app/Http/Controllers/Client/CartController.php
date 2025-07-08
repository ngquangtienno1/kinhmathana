<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Variation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingProvider;
use App\Models\PaymentMethod;
use App\Models\Promotion;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Lấy danh sách voucher đang hoạt động
        $promotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhereRaw('used_count < usage_limit');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.cart.index', compact('cartItems', 'promotions'));
    }

    public function add(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'variation_id' => 'required|exists:variations,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $variationId = $request->variation_id;
        $quantity = $request->quantity;
        $cartItem = Cart::where('user_id', $user->id)
            ->where('variation_id', $variationId)
            ->first();
        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'variation_id' => $variationId,
                'quantity' => $quantity,
            ]);
        }
        return redirect()->route('client.cart.index')->with('success', 'Đã thêm sản phẩm vào giỏ hàng!');
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        $cartItem = Cart::where('user_id', $user->id)->findOrFail($id);

        // Lấy số lượng tồn kho thực tế
        if ($cartItem->variation) {
            $maxQty = $cartItem->variation->stock_quantity;
        } else {
            $maxQty = $cartItem->product->total_stock_quantity;
        }

        $newQty = min($request->quantity, $maxQty);

        $cartItem->quantity = $newQty;
        $cartItem->save();

        // Tính lại tổng tiền dòng
        if ($cartItem->variation) {
            $price = $cartItem->variation->sale_price ?? $cartItem->variation->price;
        } else {
            $price = $cartItem->product->sale_price ?? $cartItem->product->price;
        }
        $item_total = number_format($price * $cartItem->quantity, 0, ',', '.');
        // Tính lại tổng tiền giỏ hàng
        $cart_total = Cart::where('user_id', $user->id)
            ->get()
            ->sum(function ($item) {
                if ($item->variation) {
                    $price = $item->variation->sale_price ?? $item->variation->price;
                } else {
                    $price = $item->product->sale_price ?? $item->product->price;
                }
                return $price * $item->quantity;
            });
        $cart_total = number_format($cart_total, 0, ',', '.');

        return response()->json([
            'success' => true,
            'message' => $newQty < $request->quantity ? 'Số lượng đã được giới hạn theo tồn kho!' : 'Cập nhật số lượng thành công!',
            'item_total' => $item_total,
            'cart_total' => $cart_total,
        ]);
    }

    public function remove($id)
    {
        $user = Auth::user();
        $cartItem = Cart::where('user_id', $user->id)->findOrFail($id);
        $cartItem->delete();
        return redirect()->route('client.cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function showCheckoutForm()
    {
        $user = Auth::user();
        $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
            ->where('user_id', $user->id)
            ->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }

        // Lấy danh sách phương thức vận chuyển đang hoạt động cùng với phí vận chuyển
        $shippingProviders = ShippingProvider::with(['shippingFees' => function ($query) {
            $query->orderBy('province_code');
        }])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Lấy danh sách phương thức thanh toán đang hoạt động
        $paymentMethods = PaymentMethod::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Lấy danh sách voucher đang hoạt động
        $promotions = Promotion::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function ($query) {
                $query->whereNull('usage_limit')
                    ->orWhereRaw('used_count < usage_limit');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.cart.checkout', compact('cartItems', 'shippingProviders', 'paymentMethods', 'promotions'));
    }

    public function applyVoucher(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'voucher_code' => 'required|string|max:50',
        ]);

        $voucherCode = $request->voucher_code;
        $promotion = Promotion::where('code', $voucherCode)
            ->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->first();

        if (!$promotion) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher không hợp lệ hoặc đã hết hạn!'
            ]);
        }

        // Kiểm tra giới hạn sử dụng
        if ($promotion->usage_limit && $promotion->used_count >= $promotion->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher đã hết lượt sử dụng!'
            ]);
        }

        // Kiểm tra xem user đã sử dụng voucher này chưa
        $userUsage = $promotion->usages()->where('user_id', $user->id)->first();
        if ($userUsage) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã sử dụng mã voucher này rồi!'
            ]);
        }

        // Tính tổng tiền giỏ hàng
        $cartItems = Cart::with(['variation.product'])
            ->where('user_id', $user->id)
            ->get();
        $subtotal = $cartItems->sum(function ($item) {
            if ($item->variation) {
                $price = $item->variation->sale_price ?? $item->variation->price;
            } else {
                $price = $item->product->sale_price ?? $item->product->price;
            }
            return $price * $item->quantity;
        });

        // Kiểm tra điều kiện giá trị đơn tối thiểu
        if ($subtotal < $promotion->minimum_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng phải có giá trị tối thiểu ' . number_format($promotion->minimum_purchase, 0, ',', '.') . '₫!'
            ]);
        }
        // Kiểm tra điều kiện giá trị đơn tối đa
        if ($promotion->maximum_purchase && $subtotal > $promotion->maximum_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không được vượt quá ' . number_format($promotion->maximum_purchase, 0, ',', '.') . '₫ để áp dụng mã này!'
            ]);
        }

        // Tính số tiền giảm
        $discountAmount = 0;
        if ($promotion->discount_type === 'percentage') {
            $discountAmount = $subtotal * ($promotion->discount_value / 100);
        } else {
            $discountAmount = $promotion->discount_value;
        }

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng voucher thành công!',
            'voucher' => [
                'id' => $promotion->id,
                'code' => $promotion->code,
                'name' => $promotion->name,
                'discount_type' => $promotion->discount_type,
                'discount_value' => $promotion->discount_value,
                'discount_amount' => $discountAmount,
                'description' => $promotion->description
            ]
        ]);
    }

    public function checkout(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
            ->where('user_id', $user->id)
            ->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email',
            'customer_address' => 'required|string|max:255',
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_email' => 'nullable|email',
            'shipping_address' => 'required|string|max:255',
            'shipping_method' => 'required|string',
            'payment_method' => 'required|string',
            'applied_voucher' => 'nullable|string',
            'note' => 'nullable|string|max:1000',
            'save_payment_info' => 'nullable',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên người đặt.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại người đặt.',
            'customer_address.required' => 'Vui lòng nhập địa chỉ người đặt.',
            'receiver_name.required' => 'Vui lòng nhập họ tên người nhận.',
            'receiver_phone.required' => 'Vui lòng nhập số điện thoại người nhận.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ nhận hàng.',
            'shipping_method.required' => 'Vui lòng chọn phương thức vận chuyển.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'customer_email.email' => 'Email người đặt không hợp lệ.',
            'receiver_email.email' => 'Email người nhận không hợp lệ.',
        ]);
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->variation->price * $item->quantity;
        });

        // Tính phí vận chuyển dựa trên phương thức được chọn
        $shippingCost = 0;
        $shippingProvider = null;

        if ($request->shipping_method !== 'free') {
            $shippingProvider = ShippingProvider::where('code', $request->shipping_method)
                ->where('is_active', true)
                ->first();

            if ($shippingProvider) {
                $shippingFee = $shippingProvider->shippingFees()->first();
                if ($shippingFee) {
                    $shippingCost = $shippingFee->base_fee;
                }
            }
        }

        // Xử lý voucher
        $discountAmount = 0;
        $promotion = null;

        if ($request->filled('applied_voucher')) {
            $voucherData = json_decode($request->applied_voucher, true);
            if ($voucherData && isset($voucherData['code'])) {
                $promotion = Promotion::where('code', $voucherData['code'])
                    ->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();

                if ($promotion && $totalAmount >= $promotion->minimum_purchase) {
                    if ($promotion->discount_type === 'percentage') {
                        $discountAmount = $totalAmount * ($promotion->discount_value / 100);
                    } else {
                        $discountAmount = $promotion->discount_value;
                    }
                }
            }
        }

        $grandTotal = $totalAmount + $shippingCost - $discountAmount;

        // Tìm payment method
        $paymentMethod = PaymentMethod::where('code', $request->payment_method)->first();

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'DH' . time(),
            'promotion_id' => $promotion ? $promotion->id : null,
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],
            'customer_address' => $validated['customer_address'],
            'receiver_name' => $validated['receiver_name'],
            'receiver_phone' => $validated['receiver_phone'],
            'receiver_email' => $validated['receiver_email'],
            'shipping_address' => $validated['shipping_address'],
            'total_amount' => $grandTotal,
            'subtotal' => $totalAmount,
            'promotion_amount' => $discountAmount,
            'shipping_fee' => $shippingCost,
            'shipping_provider_id' => $shippingProvider ? $shippingProvider->id : null,
            'payment_method_id' => $paymentMethod ? $paymentMethod->id : null,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'note' => $validated['note'] ?? '',
        ]);


        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->variation ? $item->variation->product_id : $item->product_id,
                'product_name' => $item->variation ? ($item->variation->product->name ?? '') : ($item->product->name ?? ''),
                'product_sku' => $item->variation ? ($item->variation->sku ?? '') : ($item->product->sku ?? ''),
                'price' => $item->variation ? $item->variation->price : ($item->product->price ?? 0),
                'quantity' => $item->quantity,
                'subtotal' => ($item->variation ? $item->variation->price : ($item->product->price ?? 0)) * $item->quantity,
                'discount_amount' => 0,
                'product_options' => $item->variation ? json_encode([
                    'color' => $item->variation->color->name ?? null,
                    'size' => $item->variation->size->name ?? null,
                ]) : null,
            ]);
            // Trừ số lượng tồn kho
            if ($item->variation) {
                $variation = $item->variation;
                $variation->stock_quantity = max(0, $variation->stock_quantity - $item->quantity);
                $variation->save();
            }
        }

        // Ghi lại việc sử dụng voucher
        if ($promotion && $discountAmount > 0) {
            \App\Models\PromotionUsage::create([
                'promotion_id' => $promotion->id,
                'order_id' => $order->id,
                'user_id' => $user->id,
                'discount_amount' => $discountAmount
            ]);

            // Tăng số lượt sử dụng
            $promotion->increment('used_count');
        }

        Cart::where('user_id', $user->id)->delete();
        return redirect()->route('client.orders.index')->with('success', 'Đặt hàng thành công!');
    }
}