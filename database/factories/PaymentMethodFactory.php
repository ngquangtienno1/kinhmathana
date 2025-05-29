<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'Thanh toán qua thẻ tín dụng',
                'Chuyển khoản ngân hàng trực tiếp',
                'Thanh toán bằng tiền mặt khi nhận hàng',
                'Thanh toán qua ví điện tử MoMo',
                'Thanh toán qua ví điện tử VNPay',
                'Thanh toán qua ví điện tử ZaloPay'
            ]),
            'description' => fake()->sentence(6),
            'is_active' => fake()->boolean(90),
            'logo_url' => null, // hoặc có thể random ảnh mẫu nếu muốn
        ];
    }
}