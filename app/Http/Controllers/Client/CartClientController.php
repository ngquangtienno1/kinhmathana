<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promotion;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PromotionUsage;
use App\Models\ShippingProvider;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
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
        $variation = Variation::findOrFail($variationId);
        $maxStock = $variation->stock_quantity ?? $variation->stock ?? 0;
        if ($maxStock <= 0) {
            return redirect()->route('client.cart.index')->with('error', 'Sản phẩm đã hết hàng!');
        }
        $cartItem = Cart::where('user_id', $user->id)
            ->where('variation_id', $variationId)
            ->first();
        $currentQty = $cartItem ? $cartItem->quantity : 0;
        $totalQty = $currentQty + $quantity;
        if ($totalQty > $maxStock) {
            return redirect()->route('client.cart.index')->with('error', 'Thất bại! Số lượng tồn kho không đủ');
        }
        if ($cartItem) {
            $cartItem->quantity = $totalQty;
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
            ->orderBy('updated_at', 'desc')
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

    //xoá nhiều sản phẩm (Tuấn Anh)
    public function bulkRemove(Request $request)
    {
        $user = Auth::user();
        $ids = $request->input('selected_ids', []);
        if (!is_array($ids) || empty($ids)) {

            return redirect()->route('client.cart.index')->with('error', 'Vui lòng chọn sản phẩm để xoá!');
        }
        Cart::where('user_id', $user->id)->whereIn('id', $ids)->delete();
        return redirect()->route('client.cart.index')->with('success', 'Đã xoá các sản phẩm đã chọn khỏi giỏ hàng!');
    }

    public function showCheckoutForm(Request $request)
    {
        $user = Auth::user();
        $selectedIds = $request->input('selected_ids');
        if ($selectedIds) {
            $ids = is_array($selectedIds) ? $selectedIds : explode(',', $selectedIds);
            Log::info('IDs used for filtering cart', ['ids' => $ids]);
            $checkoutItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->whereIn('id', $ids)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            // Nếu không có selected_ids, lấy toàn bộ giỏ hàng
            $checkoutItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->get();
        }
        Log::info('Cart items for checkout', ['cart_item_ids' => $checkoutItems->pluck('id')->toArray()]);
        if ($checkoutItems->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
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

        return view('client.cart.checkout', compact('checkoutItems', 'shippingProviders', 'paymentMethods', 'promotions'));
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
            ->orderBy('updated_at', 'desc')
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
        // Không để giảm vượt quá tổng đơn(Tuấn Anh)
        $maxDiscount = $subtotal;
        if (isset($shippingFee)) {
            $maxDiscount += $shippingFee;
        }
        if ($discountAmount > $maxDiscount) {
            $discountAmount = $maxDiscount;
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
        $user = Auth::user();
        $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
            ->where('user_id', $user->id)
            ->orderBy('updated_at', 'desc')
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
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
            'note' => 'nullable|string|max:1000',
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên khách hàng.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại khách hàng.',
            'customer_address.required' => 'Vui lòng nhập địa chỉ khách hàng.',
            'receiver_name.required' => 'Vui lòng nhập họ tên người nhận.',
            'receiver_phone.required' => 'Vui lòng nhập số điện thoại người nhận.',
            'address.required' => 'Vui lòng nhập địa chỉ chi tiết.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'shipping_method.required' => 'Vui lòng chọn phương thức vận chuyển.',
        ]);

        // Tính tổng tiền hàng
        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->variation ? ($item->variation->sale_price ?? $item->variation->price) : ($item->product->sale_price ?? $item->product->price);
            return $price * $item->quantity;
        });

        // Tính phí vận chuyển động
        $shippingProvider = ShippingProvider::where('code', $request->shipping_method)->first();
        $shippingFee = 0;
        if ($shippingProvider && $shippingProvider->shippingFees->count() > 0) {
            $shippingFee = $shippingProvider->shippingFees->first()->base_fee;
        } else {
            $shippingFee = 30000;
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
                if ($promotion && $subtotal >= $promotion->minimum_purchase) {
                    if ($promotion->discount_type === 'percentage') {
                        $discountAmount = $subtotal * ($promotion->discount_value / 100);
                    } else {
                        $discountAmount = $promotion->discount_value;
                    }
                }
            }
        }

        $grandTotal = $subtotal + $shippingFee - $discountAmount;
        if ($grandTotal < 0) $grandTotal = 0;
        $paymentMethod = PaymentMethod::where('code', $request->payment_method)->first();

        // Lưu đơn hàng
        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'DH' . time(),
            'promotion_id' => $promotion ? $promotion->id : null,
            'shipping_provider_id' => $shippingProvider ? $shippingProvider->id : null,
            'customer_name' => $request->input('customer_name', $user->name),
            'customer_phone' => $request->input('customer_phone', $user->phone),
            'customer_email' => $request->input('customer_email', $user->email),
            'customer_address' => $request->input('customer_address', $user->address),
            'receiver_name' => $validated['receiver_name'],
            'receiver_phone' => $validated['receiver_phone'],
            'receiver_email' => $validated['receiver_email'] ?? null,
            'shipping_address' => $validated['address'],
            'total_amount' => $grandTotal,
            'subtotal' => $subtotal,
            'promotion_amount' => $discountAmount,
            'shipping_fee' => $shippingFee,
            'payment_method_id' => $paymentMethod ? $paymentMethod->id : null,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'note' => $validated['note'] ?? '',
        ]);
        // Nếu shipping_provider_id vẫn NULL nhưng $shippingProvider có id, cập nhật lại
        if ($order->shipping_provider_id === null && $shippingProvider && $shippingProvider->id) {
            $order->shipping_provider_id = $shippingProvider->id;
            $order->save();
        }

        // Lưu từng sản phẩm trong đơn hàng
        foreach ($cartItems as $item) {
            $price = $item->variation ? ($item->variation->sale_price ?? $item->variation->price) : ($item->product->sale_price ?? $item->product->price);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->variation ? $item->variation->product_id : $item->product_id,
                'variation_id' => $item->variation ? $item->variation->id : null, // Lưu variation_id
                'product_name' => $item->variation ? ($item->variation->product->name ?? '') : ($item->product->name ?? ''),
                'product_sku' => $item->variation ? ($item->variation->sku ?? '') : ($item->product->sku ?? ''),
                'price' => $price,
                'quantity' => $item->quantity,
                'subtotal' => $price * $item->quantity,
                'discount_amount' => 0,
                'product_options' => $item->variation ? json_encode([
                    'color' => $item->variation->color->name ?? null,
                    'size' => $item->variation->size->name ?? null,
                    'spherical' => $item->variation->spherical->name ?? null,
                    'cylindrical' => $item->variation->cylindrical->name ?? null,
                ]) : null,
                'note' => null,
            ]);
            // Trừ tồn kho
            if ($item->variation) {
                $variation = $item->variation;
                $variation->stock_quantity = max(0, $variation->stock_quantity - $item->quantity);
                $variation->save();
            } elseif ($item->product) {
                $product = $item->product;
                $product->stock_quantity = max(0, $product->stock_quantity - $item->quantity);
                $product->save();
            }
        }
        // Ghi lại việc sử dụng voucher
        if ($promotion && $discountAmount > 0) {
            PromotionUsage::create([
                'promotion_id' => $promotion->id,
                'order_id' => $order->id,
                'user_id' => $user->id,
                'discount_amount' => $discountAmount
            ]);
            $promotion->increment('used_count');
        }
        Cart::where('user_id', $user->id)->delete();
        return redirect()->route('client.orders.index')->with('success', 'Đặt hàng thành công!');
    }

    //Tuấn Anh
    public function addToCartDirect($data, $userId)
    {
        $query = [
            'user_id' => $userId,
            'product_id' => $data['product_id'],
            'variation_id' => $data['variation_id'] ?? null,
        ];

        $cartItem = \App\Models\Cart::where($query)->first();

        if ($cartItem) {
            $cartItem->quantity += $data['quantity'];
            $cartItem->save();
        } else {
            \App\Models\Cart::create([
                'user_id' => $userId,
                'product_id' => $data['product_id'],
                'variation_id' => $data['variation_id'] ?? null,
                'quantity' => $data['quantity'],
            ]);
        }
    }
}