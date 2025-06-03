<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'payment_method_id' => PaymentMethod::where('is_active', true)->inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed', 'cancelled']),
            'transaction_code' => $this->faker->unique()->uuid,
            'amount' => $this->faker->randomFloat(2, 100000, 10000000), // Số tiền từ 100k đến 10tr
            'note' => $this->faker->optional()->sentence,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}