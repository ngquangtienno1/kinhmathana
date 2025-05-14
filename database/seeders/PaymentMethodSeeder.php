<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Fake dữ liệu cho bảng payment_methods
        DB::table('payment_methods')->insert([
            ['name' => 'Thẻ tín dụng', 'description' => 'Thanh toán qua thẻ tín dụng'],
            ['name' => 'Momo', 'description' => 'Thanh toán qua tài khoản MoMo'],
            ['name' => 'Chuyển khoản ngân hàng', 'description' => 'Chuyển khoản ngân hàng trực tiếp'],
            ['name' => 'Thanh toán khi nhận hàng', 'description' => 'Thanh toán bằng tiền mặt khi nhận hàng'],
        ]);
    }
}
