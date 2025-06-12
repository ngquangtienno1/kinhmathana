<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo các phương thức thanh toán mặc định
        $paymentMethods = [
            [
                'name' => 'Thanh toán khi nhận hàng (COD)',
                'code' => 'cod',
                'description' => 'Thanh toán bằng tiền mặt khi nhận hàng',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name' => 'Chuyển khoản ngân hàng',
                'code' => 'banking',
                'description' => 'Chuyển khoản trực tiếp qua ngân hàng',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Ví điện tử MoMo',
                'code' => 'momo',
                'description' => 'Thanh toán qua ví điện tử MoMo',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Ví điện tử VNPay',
                'code' => 'vnpay',
                'description' => 'Thanh toán qua ví điện tử VNPay',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name' => 'Thẻ tín dụng/ghi nợ',
                'code' => 'card',
                'description' => 'Thanh toán qua thẻ tín dụng hoặc thẻ ghi nợ',
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }

        // Tạo thêm một số phương thức thanh toán ngẫu nhiên nếu cần
        // PaymentMethod::factory()->count(3)->create();
    }
}