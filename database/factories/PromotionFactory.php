<?php

namespace Database\Factories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PromotionFactory extends Factory
{
    protected $model = Promotion::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, '+3 months');
        $discountType = $this->faker->randomElement(['percentage', 'fixed']);
        $discountValue = $discountType === 'percentage'
            ? $this->faker->numberBetween(5, 50)
            : $this->faker->numberBetween(10000, 100000);

        return [
            'name' => $this->faker->words(3, true),
            'code' => strtoupper($this->faker->unique()->bothify('PROMO-####')),
            'description' => $this->faker->sentence(),
            'discount_type' => $discountType,
            'discount_value' => $discountValue,
            'minimum_purchase' => $this->faker->numberBetween(0, 500000),
            'usage_limit' => $this->faker->optional(0.7)->numberBetween(10, 100),
            'used_count' => 0,
            'is_active' => $this->faker->boolean(80),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}