<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo một số promotions mẫu
        $promotions = [
            [
                'name' => 'Giảm 10% cho đơn hàng đầu tiên',
                'code' => 'WELCOME10',
                'description' => 'Giảm 10% cho đơn hàng đầu tiên của khách hàng mới.',
                'discount_type' => 'percentage',
                'discount_value' => 10.00,
                'minimum_purchase' => 100000.00,
                'maximum_purchase' => 500000.00,
                'usage_limit' => null,
                'used_count' => 0,
                'is_active' => true,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->addDays(30),
            ],
            [
                'name' => 'Miễn phí vận chuyển',
                'code' => 'FREESHIP',
                'description' => 'Miễn phí vận chuyển cho đơn hàng trên 500k.',
                'discount_type' => 'fixed',
                'discount_value' => 30000.00, // Giả sử phí ship là 30k
                'minimum_purchase' => 500000.00,
                'maximum_purchase' => 30000.00, // Giới hạn giảm tối đa bằng phí ship
                'usage_limit' => 100,
                'used_count' => 0,
                'is_active' => true,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->addDays(60),
            ],
            [
                'name' => 'Giảm giá đặc biệt 50k',
                'code' => 'GIAM50K',
                'description' => 'Giảm trực tiếp 50k cho đơn hàng.',
                'discount_type' => 'fixed',
                'discount_value' => 50000.00,
                'minimum_purchase' => 200000.00,
                'maximum_purchase' => null,
                'usage_limit' => 50,
                'used_count' => 0,
                'is_active' => true,
                'start_date' => Carbon::now()->subDays(5),
                'end_date' => Carbon::now()->addDays(15),
            ],
        ];

        foreach ($promotions as $promotion) {
            Promotion::create($promotion);
        }

        // Tạo thêm một vài promotions ngẫu nhiên nếu cần
        // Promotion::factory()->count(5)->create();
    }
}
