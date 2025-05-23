<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Discount;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $discount = Discount::inRandomOrder()->first();
        $subtotal = $this->faker->randomFloat(2, 100000, 2000000);
        $shippingFee = $this->faker->randomFloat(2, 15000, 50000);
        $discountAmount = $discount ? $this->faker->randomFloat(2, 10000, 200000) : 0;
        $totalAmount = $subtotal + $shippingFee - $discountAmount;

        $paymentMethods = ['cod', 'banking', 'momo', 'vnpay', 'zalopay'];
        $paymentStatuses = [
            'pending',
            'paid',
            'failed',
            'refunded',
            'cancelled',
            'partially_paid',
            'disputed'
        ];
        $orderStatuses = [
            'pending',
            'awaiting_payment',
            'confirmed',
            'processing',
            'shipping',
            'delivered',
            'returned',
            'processing_return',
            'refunded'
        ];

        return [
            'order_number'      => 'ORD-' . $this->faker->unique()->numberBetween(10000, 99999),
            'user_id'           => $user->id,
            'discount_id'       => $discount ? $discount->id : null,
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
            'discount_amount'   => $discountAmount,
            'shipping_fee'      => $shippingFee,
            'payment_method'    => $this->faker->randomElement($paymentMethods),
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
