<?php

namespace App\Http\Controllers\Client;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\Promotion;
use App\Models\Variation;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PromotionUsage;
use App\Models\ShippingProvider;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|exists:products,id', // Validate product_id
            'variation_id' => 'nullable|exists:variations,id', // variation_id is optional
        ]);

        $productId = $request->product_id;
        $variationId = $request->variation_id;
        $quantity = $request->quantity;

        // Check if the product has variations
        $variation = $variationId ? Variation::find($variationId) : null;
        if ($variation) {
            $maxQuantity = $variation->quantity ?? 0;
            if ($maxQuantity <= 0) {
                return redirect()->route('client.cart.index')->with('error', 'Sản phẩm đã hết hàng!');
            }
            $cartItem = Cart::where('user_id', $user->id)
                ->where('variation_id', $variationId)
                ->first();
        } else {
            // For simple products without variations
            $product = \App\Models\Product::findOrFail($productId);
            $maxQuantity = $product->quantity ?? 0;
            if ($maxQuantity <= 0) {
                return redirect()->route('client.cart.index')->with('error', 'Sản phẩm đã hết hàng!');
            }
            $cartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $productId)
                ->whereNull('variation_id')
                ->first();
        }

        $currentQty = $cartItem ? $cartItem->quantity : 0;
        $totalQty = $currentQty + $quantity;

        if ($totalQty > $maxQuantity) {
            return redirect()->route('client.cart.index')->with('error', 'Thất bại! Số lượng tồn kho không đủ');
        }

        if ($cartItem) {
            $cartItem->quantity = $totalQty;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
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
            $maxQty = $cartItem->variation->quantity ?? 0;
        } else {
            $maxQty = $cartItem->product->quantity ?? 0;
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
            $checkoutItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->whereIn('id', $ids)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $checkoutItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->get();
        }
        if ($checkoutItems->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
        }

        $shippingProviders = ShippingProvider::with([
            'shippingFees' => function ($query) {
                $query->orderBy('province_code');
            }
        ])
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $paymentMethods = PaymentMethod::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

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

        if ($promotion->usage_limit && $promotion->used_count >= $promotion->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Mã voucher đã hết lượt sử dụng!'
            ]);
        }

        $userUsage = $promotion->usages()->where('user_id', $user->id)->first();
        if ($userUsage) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã sử dụng mã voucher này rồi!'
            ]);
        }

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

        if ($subtotal < $promotion->minimum_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng phải có giá trị tối thiểu ' . number_format($promotion->minimum_purchase, 0, ',', '.') . '₫!'
            ]);
        }

        if ($promotion->maximum_purchase && $subtotal > $promotion->maximum_purchase) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn hàng không được vượt quá ' . number_format($promotion->maximum_purchase, 0, ',', '.') . '₫ để áp dụng mã này!'
            ]);
        }

        $discountAmount = 0;
        if ($promotion->discount_type === 'percentage') {
            $discountAmount = $subtotal * ($promotion->discount_value / 100);
        } else {
            $discountAmount = $promotion->discount_value;
        }
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
        $selectedIds = $request->input('selected_ids');
        if ($selectedIds) {
            $ids = is_array($selectedIds) ? $selectedIds : explode(',', $selectedIds);
            $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->whereIn('id', $ids)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->get();
        }
        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Vui lòng chọn sản phẩm để thanh toán!');
        }
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_email' => 'nullable|email',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
            'note' => 'nullable|string|max:1000',
        ], [
            'receiver_name.required' => 'Vui lòng nhập họ tên người nhận.',
            'receiver_phone.required' => 'Vui lòng nhập số điện thoại người nhận.',
            'address.required' => 'Vui lòng nhập địa chỉ chi tiết.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'shipping_method.required' => 'Vui lòng chọn phương thức vận chuyển.',
        ]);

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->variation ? ($item->variation->sale_price ?? $item->variation->price) : ($item->product->sale_price ?? $item->product->price);
            return $price * $item->quantity;
        });

        $shippingProvider = ShippingProvider::where('code', $request->shipping_method)->first();
        $shippingFee = 0;
        if ($shippingProvider && $shippingProvider->shippingFees->count() > 0) {
            $shippingFee = $shippingProvider->shippingFees->first()->base_fee;
        } else {
            $shippingFee = 30000;
        }

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
        if ($grandTotal < 0)
            $grandTotal = 0;
        $paymentMethod = PaymentMethod::where('code', $request->payment_method)->first();

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'DH' . time(),
            'promotion_id' => $promotion ? $promotion->id : null,
            'shipping_provider_id' => $shippingProvider ? $shippingProvider->id : null,
            'customer_name' => $validated['receiver_name'],
            'customer_phone' => $validated['receiver_phone'],
            'customer_email' => $validated['receiver_email'] ?? null,
            'customer_address' => $validated['address'],
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
        if ($order->shipping_provider_id === null && $shippingProvider && $shippingProvider->id) {
            $order->shipping_provider_id = $shippingProvider->id;
            $order->save();
        }

        foreach ($cartItems as $item) {
            $price = $item->variation ? ($item->variation->sale_price ?? $item->variation->price) : ($item->product->sale_price ?? $item->product->price);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->variation ? $item->variation->product_id : $item->product_id,
                'variation_id' => $item->variation ? $item->variation->id : null,
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
        }

        // Trừ số lượng sản phẩm sau khi tạo đơn hàng thành công
        try {
            foreach ($cartItems as $item) {
                if ($item->variation_id) {
                    $variation = Variation::find($item->variation_id);
                    if ($variation) {
                        $variation->quantity = max(0, $variation->quantity - $item->quantity);
                        $variation->save();
                    }
                } else {
                    $product = \App\Models\Product::find($item->product_id);
                    if ($product) {
                        $product->quantity = max(0, $product->quantity - $item->quantity);
                        $product->save();
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Lỗi trừ số lượng sản phẩm sau khi đặt hàng: ' . $e->getMessage());
        }

        // Ghi log sử dụng khuyến mãi nếu có
        if ($promotion && $discountAmount > 0) {
            try {
                if (!\App\Models\PromotionUsage::where('promotion_id', $promotion->id)
                    ->where('order_id', $order->id)
                    ->exists()) {
                    \App\Models\PromotionUsage::create([
                        'promotion_id' => $promotion->id,
                        'order_id' => $order->id,
                        'user_id' => $order->user_id,
                        'discount_amount' => $discountAmount
                    ]);
                    $promotion->increment('used_count');
                }
            } catch (\Exception $e) {
                Log::error('Lỗi ghi log sử dụng khuyến mãi: ' . $e->getMessage());
            }
        }

        if ($selectedIds) {
            Cart::where('user_id', $user->id)->whereIn('id', $ids)->delete();
        } else {
            Cart::where('user_id', $user->id)->delete();
        }

        $this->updateCustomerAfterOrder($user->id);

        try {
            if ($order->receiver_email) {
                Mail::to($order->receiver_email)->send(new \App\Mail\OrderPlaced($order));
            } elseif ($order->customer_email) {
                Mail::to($order->customer_email)->send(new \App\Mail\OrderPlaced($order));
            }
        } catch (\Exception $e) {
            Log::error('Lỗi gửi mail OrderPlaced (client): ' . $e->getMessage());
        }

        return redirect()->route('client.orders.index')->with('success', 'Đặt hàng thành công!');
    }

    public function addToCartDirect($data, $userId)
    {
        $query = [
            'user_id' => $userId,
            'product_id' => $data['product_id'],
            'variation_id' => $data['variation_id'] ?? null,
        ];

        // Validate quantity before adding
        if (isset($data['variation_id']) && $data['variation_id']) {
            $variation = Variation::find($data['variation_id']);
            if (!$variation) {
                return false; // Variation not found
            }
            $maxQuantity = $variation->quantity ?? 0;
        } else {
            $product = \App\Models\Product::find($data['product_id']);
            if (!$product) {
                return false; // Product not found
            }
            $maxQuantity = $product->quantity ?? 0;
        }

        if ($maxQuantity <= 0) {
            return false; // Out of quantity
        }

        $cartItem = Cart::where($query)->first();
        $quantity = $data['quantity'] ?? 1;
        $currentQty = $cartItem ? $cartItem->quantity : 0;
        $totalQty = $currentQty + $quantity;

        if ($totalQty > $maxQuantity) {
            return false; // Insufficient quantity
        }

        if ($cartItem) {
            $cartItem->quantity = $totalQty;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $data['product_id'],
                'variation_id' => $data['variation_id'] ?? null,
                'quantity' => $quantity,
            ]);
        }

        return true;
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function momo_payment(Request $request)
    {
        $user = Auth::user();
        $selectedIds = $request->input('selected_ids');
        if ($selectedIds) {
            $ids = is_array($selectedIds) ? $selectedIds : explode(',', $selectedIds);
            $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->whereIn('id', $ids)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_email' => 'nullable|email',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
            'note' => 'nullable|string|max:1000',
        ], [
            'receiver_name.required' => 'Vui lòng nhập họ tên người nhận.',
            'receiver_phone.required' => 'Vui lòng nhập số điện thoại người nhận.',
            'address.required' => 'Vui lòng nhập địa chỉ chi tiết.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'shipping_method.required' => 'Vui lòng chọn phương thức vận chuyển.',
        ]);

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->variation ? ($item->variation->sale_price ?? $item->variation->price) : ($item->product->sale_price ?? $item->product->price);
            return $price * $item->quantity;
        });

        $shippingProvider = ShippingProvider::where('code', $request->shipping_method)->first();
        $shippingFee = 0;
        if ($shippingProvider && $shippingProvider->shippingFees->count() > 0) {
            $shippingFee = $shippingProvider->shippingFees->first()->base_fee;
        } else {
            $shippingFee = 30000;
        }

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
        if ($grandTotal < 0)
            $grandTotal = 0;
        $paymentMethod = PaymentMethod::where('code', $request->payment_method)->first();

        $momoOrderId = 'MOMO' . time();

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'DH' . time(),
            'promotion_id' => $promotion ? $promotion->id : null,
            'shipping_provider_id' => $shippingProvider ? $shippingProvider->id : null,
            'customer_name' => $validated['receiver_name'],
            'customer_phone' => $validated['receiver_phone'],
            'customer_email' => $validated['receiver_email'] ?? null,
            'customer_address' => $validated['address'],
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
            'payment_gateway' => 'momo',
            'payment_gateway_order_id' => $momoOrderId,
        ]);
        if ($order->shipping_provider_id === null && $shippingProvider && $shippingProvider->id) {
            $order->shipping_provider_id = $shippingProvider->id;
            $order->save();
        }
        foreach ($cartItems as $item) {
            $price = $item->variation ? ($item->variation->sale_price ?? $item->variation->price) : ($item->product->sale_price ?? $item->product->price);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->variation ? $item->variation->product_id : $item->product_id,
                'variation_id' => $item->variation ? $item->variation->id : null,
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
        }

        $paymentMethod = PaymentMethod::where('code', 'momo')->first();
        $apiSettings = $paymentMethod && $paymentMethod->api_settings ? json_decode($paymentMethod->api_settings, true) : [];
        $partnerCode = $paymentMethod->api_key ?? '';
        $accessKey = $apiSettings['accessKey'] ?? '';
        $secretKey = $paymentMethod->api_secret ?? '';
        $endpoint = $paymentMethod->api_endpoint ?? 'https://test-payment.momo.vn/v2/gateway/api/create';

        $orderInfo = "Thanh toán qua MoMo";
        $amount = (string) intval($grandTotal);
        $orderId = $momoOrderId;
        $redirectUrl = route('client.cart.thankyou');
        $ipnUrl = route('client.cart.thankyou');
        $extraData = "";
        $requestId = time() . "";
        $requestType = "payWithATM";
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );
        $result = $this->execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);
        if (isset($jsonResult['payUrl'])) {
            return redirect()->to($jsonResult['payUrl']);
        } else {
            return redirect()->route('client.cart.checkout.form')->with('error', 'Không thể kết nối MoMo. Vui lòng thử lại!');
        }
    }

    public function vnpay_payment(Request $request)
    {
        $user = Auth::user();
        $selectedIds = $request->input('selected_ids');
        if ($selectedIds) {
            $ids = is_array($selectedIds) ? $selectedIds : explode(',', $selectedIds);
            $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->whereIn('id', $ids)
                ->orderBy('updated_at', 'desc')
                ->get();
        } else {
            $cartItems = Cart::with(['variation.product', 'variation.color', 'variation.size'])
                ->where('user_id', $user->id)
                ->orderBy('updated_at', 'desc')
                ->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        $validated = $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_email' => 'nullable|email',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|string',
            'shipping_method' => 'required|string',
            'note' => 'nullable|string|max:1000',
        ], [
            'receiver_name.required' => 'Vui lòng nhập họ tên người nhận.',
            'receiver_phone.required' => 'Vui lòng nhập số điện thoại người nhận.',
            'address.required' => 'Vui lòng nhập địa chỉ chi tiết.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
            'shipping_method.required' => 'Vui lòng chọn phương thức vận chuyển.',
        ]);

        $subtotal = $cartItems->sum(function ($item) {
            $price = $item->variation ? ($item->variation->sale_price ?? $item->variation->price) : ($item->product->sale_price ?? $item->product->price);
            return $price * $item->quantity;
        });

        $shippingProvider = ShippingProvider::where('code', $request->shipping_method)->first();
        $shippingFee = 0;
        if ($shippingProvider && $shippingProvider->shippingFees->count() > 0) {
            $shippingFee = $shippingProvider->shippingFees->first()->base_fee;
        } else {
            $shippingFee = 30000;
        }

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
        if ($grandTotal < 0)
            $grandTotal = 0;
        $paymentMethod = PaymentMethod::where('code', $request->payment_method)->first();

        $vnpOrderId = 'VNPAY' . time();

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'DH' . time(),
            'promotion_id' => $promotion ? $promotion->id : null,
            'shipping_provider_id' => $shippingProvider ? $shippingProvider->id : null,
            'customer_name' => $validated['receiver_name'],
            'customer_phone' => $validated['receiver_phone'],
            'customer_email' => $validated['receiver_email'] ?? null,
            'customer_address' => $validated['address'],
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
            'payment_gateway' => 'vnpay',
            'payment_gateway_order_id' => $vnpOrderId,
        ]);
        if ($order->shipping_provider_id === null && $shippingProvider && $shippingProvider->id) {
            $order->shipping_provider_id = $shippingProvider->id;
            $order->save();
        }
        foreach ($cartItems as $item) {
            $price = $item->variation ? ($item->variation->sale_price ?? $item->variation->price) : ($item->product->sale_price ?? $item->product->price);
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->variation ? $item->variation->product_id : $item->product_id,
                'variation_id' => $item->variation ? $item->variation->id : null,
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
        }

        $paymentMethod = PaymentMethod::where('code', 'vnpay')->first();
        $apiSettings = $paymentMethod && $paymentMethod->api_settings ? json_decode($paymentMethod->api_settings, true) : [];
        $vnp_Url = $paymentMethod->api_endpoint ?? 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
        $vnp_Returnurl = route('client.cart.thankyou');
        $vnp_TmnCode = $paymentMethod->api_key ?? '';
        $vnp_HashSecret = $paymentMethod->api_secret ?? '';

        $vnp_TxnRef = $vnpOrderId;
        $vnp_OrderInfo = 'Thanh toán đơn hàng #' . $order->order_number;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $grandTotal * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect()->to($vnp_Url);
    }

    public function momoThankYou(Request $request)
    {
        if ($request->has('vnp_TransactionNo')) {
            $vnp_TxnRef = $request->input('vnp_TxnRef');
            $vnp_ResponseCode = $request->input('vnp_ResponseCode');
            $order = Order::where('payment_gateway', 'vnpay')->where('payment_gateway_order_id', $vnp_TxnRef)->first();

            if ($order) {
                if ($vnp_ResponseCode == '00') {
                    $order->payment_status = 'paid';
                    $order->status = 'confirmed';
                    $order->save();
                    Cart::where('user_id', $order->user_id)->delete();

                    if (!Payment::where('transaction_code', $vnp_TxnRef)->exists()) {
                        Payment::create([
                            'order_id' => $order->id,
                            'status' => 'đã hoàn thành',
                            'transaction_code' => $vnp_TxnRef,
                            'payment_method_id' => $order->payment_method_id,
                            'amount' => $order->total_amount,
                            'note' => 'Thanh toán qua VNPAY',
                            'paid_at' => now(),
                            'user_id' => $order->user_id,
                        ]);
                    }

                    try {
                        if ($order->receiver_email) {
                            Mail::to($order->receiver_email)->send(new \App\Mail\OrderPlaced($order));
                        } elseif ($order->customer_email) {
                            Mail::to($order->customer_email)->send(new \App\Mail\OrderPlaced($order));
                        }
                    } catch (\Exception $e) {
                        Log::error('Lỗi gửi mail OrderPlaced (VNPAY): ' . $e->getMessage());
                    }

                    // Deduct inventory and record promotion usage after successful VNPAY payment
                    try {
                        foreach ($order->items as $item) {
                            if ($item->variation_id) {
                                $variation = Variation::find($item->variation_id);
                                if ($variation) {
                                    $variation->quantity = max(0, $variation->quantity - $item->quantity);
                                    $variation->save();
                                }
                            } else {
                                $product = \App\Models\Product::find($item->product_id);
                                if ($product) {
                                    $product->quantity = max(0, $product->quantity - $item->quantity);
                                    $product->save();
                                }
                            }
                        }
                        if ($order->promotion_id && $order->promotion_amount > 0) {
                            if (!PromotionUsage::where('promotion_id', $order->promotion_id)
                                ->where('order_id', $order->id)
                                ->exists()) {
                                PromotionUsage::create([
                                    'promotion_id' => $order->promotion_id,
                                    'order_id' => $order->id,
                                    'user_id' => $order->user_id,
                                    'discount_amount' => $order->promotion_amount
                                ]);
                                \App\Models\Promotion::where('id', $order->promotion_id)->increment('used_count');
                            }
                        }
                    } catch (\Exception $e) {
                        Log::error('Lỗi xử lý tồn kho/khuyến mãi sau VNPAY: ' . $e->getMessage());
                    }

                    return view('client.cart.thankyou');
                } else {
                    return redirect()->route('client.cart.checkout.form')->with('error', 'Thanh toán thất bại hoặc bị huỷ! (Mã: ' . $vnp_ResponseCode . ')');
                }
            } else {
                return redirect()->route('client.cart.checkout.form')->with('error', 'Không tìm thấy đơn hàng!');
            }
        }

        $orderId = $request->input('orderId');
        $resultCode = $request->input('resultCode');
        $message = $request->input('message');
        $order = Order::where('payment_gateway', 'momo')->where('payment_gateway_order_id', $orderId)->first();

        if ($order) {
            if (in_array($resultCode, [0, '0', 9000, '9000'])) {
                $order->payment_status = 'paid';
                $order->status = 'confirmed';
                $order->save();
                Cart::where('user_id', $order->user_id)->delete();

                if (!Payment::where('transaction_code', $orderId)->exists()) {
                    Payment::create([
                        'order_id' => $order->id,
                        'status' => 'đã hoàn thành',
                        'transaction_code' => $orderId,
                        'payment_method_id' => $order->payment_method_id,
                        'amount' => $order->total_amount,
                        'note' => 'Thanh toán qua MoMo',
                        'paid_at' => now(),
                        'user_id' => $order->user_id,
                    ]);
                }

                try {
                    if ($order->receiver_email) {
                        Mail::to($order->receiver_email)->send(new \App\Mail\OrderPlaced($order));
                    } elseif ($order->customer_email) {
                        Mail::to($order->customer_email)->send(new \App\Mail\OrderPlaced($order));
                    }
                } catch (\Exception $e) {
                    Log::error('Lỗi gửi mail OrderPlaced (MoMo): ' . $e->getMessage());
                }

                // Deduct inventory and record promotion usage after successful MoMo payment
                try {
                    foreach ($order->items as $item) {
                        if ($item->variation_id) {
                            $variation = Variation::find($item->variation_id);
                            if ($variation) {
                                $variation->quantity = max(0, $variation->quantity - $item->quantity);
                                $variation->save();
                            }
                        } else {
                            $product = \App\Models\Product::find($item->product_id);
                            if ($product) {
                                $product->quantity = max(0, $product->quantity - $item->quantity);
                                $product->save();
                            }
                        }
                    }
                    if ($order->promotion_id && $order->promotion_amount > 0) {
                        if (!PromotionUsage::where('promotion_id', $order->promotion_id)
                            ->where('order_id', $order->id)
                            ->exists()) {
                            PromotionUsage::create([
                                'promotion_id' => $order->promotion_id,
                                'order_id' => $order->id,
                                'user_id' => $order->user_id,
                                'discount_amount' => $order->promotion_amount
                            ]);
                            \App\Models\Promotion::where('id', $order->promotion_id)->increment('used_count');
                        }
                    }
                } catch (\Exception $e) {
                    Log::error('Lỗi xử lý tồn kho/khuyến mãi sau MoMo: ' . $e->getMessage());
                }

                return view('client.cart.thankyou');
            } elseif (in_array($resultCode, [7002, '7002'])) {
                return view('client.cart.thankyou', ['pending' => true]);
            } else {
                return redirect()->route('client.cart.checkout.form')->with('error', 'Thanh toán thất bại hoặc bị huỷ! (Mã: ' . $resultCode . ')');
            }
        } else {
            return redirect()->route('client.cart.checkout.form')->with('error', 'Không tìm thấy đơn hàng!');
        }
    }

    private function updateCustomerAfterOrder($userId)
    {
        $customer = Customer::where('user_id', $userId)->first();
        if ($customer) {
            $orders = $customer->orders()
                ->where('payment_status', 'paid')
                ->whereIn('status', ['delivered', 'completed'])
                ->get();
            $customer->total_orders = $orders->count();
            $customer->total_spent = $orders->sum(function ($order) {
                $calculatedSubtotal = $order->items->sum(function ($item) {
                    return $item->price * $item->quantity;
                });
                return $calculatedSubtotal - ($order->promotion_amount ?? 0) + ($order->shipping_fee ?? 0);
            });
            $customer->save();
            $customer->updateCustomerType();
        }
    }
}
