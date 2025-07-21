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
                'name' => 'Ví điện tử MoMo',
                'code' => 'momo',
                'description' => 'Thanh toán qua ví điện tử MoMo',
                'api_key' => 'MOMOBKUN20180529', // partnerCode
                'api_secret' => 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa', // secretKey
                'api_endpoint' => 'https://test-payment.momo.vn/v2/gateway/api/create',
                'api_settings' => json_encode([
                    'accessKey' => 'klm05TvNBzhg7h7j'
                ]),
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name' => 'Ví điện tử VNPay',
                'code' => 'vnpay',
                'description' => 'Thanh toán qua ví điện tử VNPay',
                'api_key' => '1VYBIYQP', // vnp_TmnCode
                'api_secret' => 'NOH6MBGNLQL9O9OMMFMZ2AX8NIEP50W1', // vnp_HashSecret
                'api_endpoint' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
                'api_settings' => null,
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name' => 'Ví điện tử ZaloPay',
                'code' => 'zalopay',
                'description' => 'Thanh toán qua ví điện tử ZaloPay',
                'is_active' => true,
                'sort_order' => 4
            ],
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }

        // Tạo thêm một số phương thức thanh toán ngẫu nhiên nếu cần
        // PaymentMethod::factory()->count(3)->create();
    }
}