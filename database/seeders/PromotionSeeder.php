<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create 20 sample promotions
        Promotion::factory()->count(20)->create();

        // Create some special promotions
        Promotion::create([
            'name' => 'Summer Sale 2024',
            'code' => 'SUMMER2024',
            'description' => 'Special summer discount for all products',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'minimum_purchase' => 200000,
            'usage_limit' => 1000,
            'used_count' => 0,
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
        ]);

        Promotion::create([
            'name' => 'New Customer Discount',
            'code' => 'WELCOME50',
            'description' => '50% off for new customers',
            'discount_type' => 'percentage',
            'discount_value' => 50,
            'minimum_purchase' => 100000,
            'usage_limit' => 1,
            'used_count' => 0,
            'is_active' => true,
            'start_date' => now(),
            'end_date' => now()->addYear(),
        ]);
    }
}