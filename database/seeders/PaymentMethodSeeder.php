<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        // Dữ liệu mẫu cố định
        PaymentMethod::insert([
            [
                'name' => 'Thẻ tín dụng',
                'description' => 'Thanh toán qua thẻ tín dụng',
                'is_active' => true,
                'logo_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thanh toán qua ví điện tử MoMo',
                'description' => 'Thanh toán qua ví điện tử MoMo',
                'is_active' => true,
                'logo_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chuyển khoản ngân hàng',
                'description' => 'Chuyển khoản ngân hàng trực tiếp',
                'is_active' => true,
                'logo_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thanh toán khi nhận hàng',
                'description' => 'Thanh toán bằng tiền mặt khi nhận hàng',
                'is_active' => true,
                'logo_url' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        PaymentMethod::factory()->count(10)->create();
    }
}