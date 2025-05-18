<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::inRandomOrder()->first() ?? User::factory()->create();
        $subtotal = $this->faker->randomFloat(2, 100000, 2000000);
        $shippingFee = $this->faker->randomFloat(2, 15000, 50000);
        $discountAmount = $this->faker->boolean(30) ? $subtotal * $this->faker->randomFloat(2, 0.05, 0.2) : 0;
        $totalAmount = $subtotal + $shippingFee - $discountAmount;

        return [
            'order_number' => 'ORD-' . $this->faker->unique()->numberBetween(10000, 99999),
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_phone' => $user->phone ?? $this->faker->phoneNumber(),
            'customer_email' => $user->email,
            'customer_address' => $user->address ?? $this->faker->address(),
            'receiver_name' => $this->faker->boolean(70) ? $user->name : $this->faker->name(),
            'receiver_phone' => $this->faker->phoneNumber(),
            'receiver_email' => $this->faker->safeEmail(),
            'shipping_address' => $this->faker->address(),
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'payment_method' => $this->faker->randomElement(['cod', 'banking', 'momo', 'vnpay', 'zalopay']),
            'payment_status' => $this->faker->randomElement([
                'pending', 'paid', 'failed', 'refunded',
                'cancelled', 'partially_paid', 'disputed'
            ]),
            'status' => $this->faker->randomElement([
                'pending', 'awaiting_payment', 'confirmed',
                'processing', 'shipping', 'delivered',
                'returned', 'processing_return', 'refunded'
            ]),
            'note' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}