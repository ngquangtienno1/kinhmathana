<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;


class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = app(Faker::class); // Sử dụng Faker mặc định mà Laravel đã tích hợp sẵn

        // Lấy ID của các payment methods và orders để fake dữ liệu
        $paymentMethodIds = DB::table('payment_methods')->pluck('id')->toArray();
        $orderIds = DB::table('orders')->pluck('id')->toArray();


        foreach (range(1, 50) as $index) {
            DB::table('payments')->insert([
                'order_id' => $faker->randomElement($orderIds),
                'status' => $faker->randomElement(['đang chờ thanh toán', 'đã hoàn thành', 'thất bại', 'đã hủy']),
                'transaction_code' => $faker->unique()->uuid,
                'payment_method_id' => $faker->randomElement($paymentMethodIds),
                'amount' => $faker->randomFloat(2, 10, 1000), // Số tiền thanh toán ngẫu nhiên
                'note' => $faker->optional()->sentence, // Ghi chú về thanh toán
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}