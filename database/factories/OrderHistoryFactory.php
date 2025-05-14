<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\OrderHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderHistoryFactory extends Factory
{
    protected $model = OrderHistory::class;

    public function definition()
    {
        $statuses = [
            'pending', 'awaiting_payment', 'confirmed', 'processing',
            'shipping', 'delivered', 'returned', 'processing_return', 'refunded'
        ];
        $paymentStatuses = [
            'pending', 'paid', 'failed', 'refunded', 'cancelled',
            'partially_paid', 'disputed'
        ];

        $isStatusChange = $this->faker->boolean();
        
        if ($isStatusChange) {
            $statusIndex = array_rand($statuses);
            $fromStatus = $statusIndex > 0 ? $statuses[$statusIndex - 1] : null;
            $toStatus = $statuses[$statusIndex];
            $fromPaymentStatus = null;
            $toPaymentStatus = null;
        } else {
            $paymentStatusIndex = array_rand($paymentStatuses);
            $fromPaymentStatus = $paymentStatusIndex > 0 ? $paymentStatuses[$paymentStatusIndex - 1] : null;
            $toPaymentStatus = $paymentStatuses[$paymentStatusIndex];
            $fromStatus = null;
            $toStatus = null;
        }

        return [
            'order_id' => Order::factory(),
            'user_id' => User::factory(),
            'status_from' => $fromStatus,
            'status_to' => $toStatus,
            'payment_status_from' => $fromPaymentStatus,
            'payment_status_to' => $toPaymentStatus,
            'comment' => $this->faker->sentence(),
            'additional_data' => $this->faker->boolean(30) ? [
                'ip_address' => $this->faker->ipv4,
                'user_agent' => $this->faker->userAgent,
                'location' => $this->faker->city
            ] : null,
        ];
    }
} 