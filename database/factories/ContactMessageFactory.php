<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    public function definition()
    {
        $statuses = ['mới', 'đã đọc', 'đã trả lời', 'đã bỏ qua'];
        $isSpam = $this->faker->boolean(20); // 20% khả năng là spam

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'message' => $this->faker->paragraph(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'status' => $this->faker->randomElement($statuses),
            'reply_at' => $this->faker->optional(0.7)->dateTimeThisMonth(), // 70% khả năng có thời gian trả lời
            'replied_by' => $this->faker->optional(0.7)->randomElement(User::pluck('id')->toArray()),
            'is_spam' => $isSpam,
            'note' => $this->faker->optional(0.3)->sentence(), // 30% khả năng có ghi chú
        ];
    }

    /**
     * Đánh dấu tin nhắn là spam
     */
    public function spam()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_spam' => true,
                'status' => 'đã bỏ qua',
            ];
        });
    }

    /**
     * Đánh dấu tin nhắn đã được trả lời
     */
    public function replied()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'đã trả lời',
                'reply_at' => now(),
                'replied_by' => User::inRandomOrder()->first()->id,
            ];
        });
    }

    /**
     * Đánh dấu tin nhắn đã được đọc
     */
    public function read()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'đã đọc',
            ];
        });
    }
}