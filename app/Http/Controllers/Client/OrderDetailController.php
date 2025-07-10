<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderDetailController extends Controller
{
    public function show($id)
    {
        $user = auth()->user();
        $order = Order::with(['items.product'])->where('user_id', $user->id)->findOrFail($id);
        return response()->json([
            'order_number' => $order->order_number,
            'status' => $order->status,
            'status_label' => $order->status_label,
            'payment_status' => $order->payment_status,
            'payment_status_label' => $order->payment_status_label,
            'created_at' => $order->created_at ? $order->created_at->format('d/m/Y H:i') : null,
            'total_amount' => (float) $order->total_amount,
            'receiver_name' => $order->receiver_name,
            'receiver_phone' => $order->receiver_phone,
            'receiver_email' => $order->receiver_email,
            'shipping_address' => $order->shipping_address,
            'items' => $order->items->map(function ($item) {
                return [
                    'product_name' => $item->product_name,
                    'product_sku' => $item->product_sku,
                    'quantity' => $item->quantity,
                    'price' => (float) $item->price,
                    'subtotal' => (float) $item->subtotal,
                    'thumbnail' => $item->product && $item->product->thumbnail ? asset($item->product->thumbnail) : null,
                ];
            }),
        ]);
    }

    public function reasons()
    {
        $reasons = \App\Models\CancellationReason::where('type', 'customer')->where('is_active', true)->get(['id', 'reason']);
        return response()->json($reasons);
    }
}