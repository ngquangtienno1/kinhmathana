<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Promotion;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\ShippingProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // Lấy promotion còn hạn và đang hoạt động
        $promotion = Promotion::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->inRandomOrder()->first();

        $paymentMethod = PaymentMethod::where('is_active', true)->inRandomOrder()->first();
        $shippingProvider = ShippingProvider::where('is_active', true)->inRandomOrder()->first();

        $subtotal = $this->faker->randomFloat(2, 100000, 2000000);
        $shippingFee = $this->faker->randomFloat(2, 15000, 50000);

        $promotionAmount = 0;
        if ($promotion) {
            // Kiểm tra điều kiện mua tối thiểu nếu có
            if ($promotion->minimum_purchase > 0 && $subtotal < $promotion->minimum_purchase) {
                $promotion = null; // Không áp dụng nếu không đủ điều kiện
            } else {
                // Assume Promotion model has 'discount_type' ('fixed' or 'percentage') and 'discount_value' columns
                if ($promotion->discount_type === 'fixed') {
                    $promotionAmount = $promotion->discount_value;
                } elseif ($promotion->discount_type === 'percentage') {
                    $promotionAmount = ($subtotal * $promotion->discount_value) / 100;
                }
                // Kiểm tra giá trị giảm tối đa nếu có
                if ($promotion->maximum_purchase !== null && $promotionAmount > $promotion->maximum_purchase) {
                    $promotionAmount = $promotion->maximum_purchase;
                }
                // Ensure promotion amount doesn't exceed subtotal
                $promotionAmount = min($promotionAmount, $subtotal);
            }
        }

        $totalAmount = $subtotal + $shippingFee - $promotionAmount;
        // Ensure total amount is not negative
        $totalAmount = max(0, $totalAmount);

        $paymentStatuses = [
            'pending',
            'paid',
            'cod',
            'confirmed',
            'refunded',
            'processing_refund',
            'failed'
        ];
        $orderStatuses = [
            'pending',           // Chờ xác nhận
            'confirmed',         // Đã xác nhận
            'awaiting_pickup',   // Chờ lấy hàng
            'shipping',          // Đang giao
            'delivered',         // Đã giao hàng
            'returned',          // Khách trả hàng
            'processing_return', // Đang xử lý trả hàng
            'cancelled',         // Đã hủy
            'returned_refunded', // Trả hàng / Hoàn tiền
            'completed',         // Đã hoàn thành
            'refunded'           // Đã hoàn tiền
        ];

        return [
            'order_number'      => 'ORD-' . $this->faker->unique()->numberBetween(10000, 99999),
            'user_id'           => $user->id,
            'promotion_id'      => $promotion ? $promotion->id : null,
            'payment_method_id' => $paymentMethod ? $paymentMethod->id : null,
            'shipping_provider_id' => $shippingProvider ? $shippingProvider->id : null,
            'customer_name'     => $user->name,
            'customer_phone'    => $user->phone ?? $this->faker->phoneNumber(),
            'customer_email'    => $user->email,
            'customer_address'  => $user->address ?? $this->faker->address(),
            'receiver_name'     => $this->faker->boolean(70) ? $user->name : $this->faker->name(),
            'receiver_phone'    => $this->faker->phoneNumber(),
            'receiver_email'    => $this->faker->safeEmail(),
            'shipping_address'  => $this->faker->address(),
            'total_amount'      => $totalAmount,
            'subtotal'          => $subtotal,
            'promotion_amount'  => $promotionAmount,
            'shipping_fee'      => $shippingFee,
            'payment_details'   => null,
            'payment_status'    => $this->faker->randomElement($paymentStatuses),
            'status'            => $this->faker->randomElement($orderStatuses),
            'note'              => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'admin_note'        => $this->faker->boolean(10) ? $this->faker->sentence() : null,
            'confirmed_at'      => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'completed_at'      => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'cancelled_at'      => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'created_at'        => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at'        => now(),
            'deleted_at'        => null,
        ];
    }

    // Nếu muốn sinh luôn order_items, order_histories, order_status_logs khi dùng seeder:
    public function configure()
    {
        return $this->afterCreating(function (Order $order) {
            // Sinh 1-5 order_items
            \App\Models\OrderItem::factory()->count(rand(1, 5))->create(['order_id' => $order->id]);
            // Sinh 1-3 order_histories
            \App\Models\OrderHistory::factory()->count(rand(1, 3))->create(['order_id' => $order->id]);
            // Sinh 1-2 order_status_logs
            \App\Models\OrderStatusLog::factory()->count(rand(1, 2))->create(['order_id' => $order->id]);
        });
    }
}