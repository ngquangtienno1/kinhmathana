<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderHistoryFactory extends Factory
{
    public function definition(): array
    {
        $statuses = [
            'pending',
            'awaiting_payment',
            'confirmed',
            'processing',
            'shipping',
            'delivered',
            'returned',
            'processing_return',
            'refunded',
            'cancelled'
        ];
        $paymentStatuses = [
            'unpaid',
            'paid',
            'failed',
            'refunded',
            'cancelled',
            'partially_paid',
            'disputed'
        ];

        $statusFrom = $this->faker->randomElement($statuses);
        $statusTo = $this->faker->randomElement(array_diff($statuses, [$statusFrom]));

        return [
            'order_id' => Order::factory(),
            'user_id' => User::factory(),
            'status_from' => $statusFrom,
            'status_to' => $statusTo, // Đảm bảo luôn có giá trị
            'payment_status_from' => $this->faker->randomElement($paymentStatuses),
            'payment_status_to' => $this->faker->randomElement($paymentStatuses),
            'comment' => $this->faker->sentence(),
            'additional_data' => json_encode([
                'ip_address' => $this->faker->ipv4(),
                'user_agent' => $this->faker->userAgent(),
                'location' => $this->faker->city(),
            ]),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
