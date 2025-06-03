<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['percentage', 'fixed_amount']);

        return [
            'code' => $this->faker->unique()->word() . $this->faker->numberBetween(10, 99),
            'type' => $type,
            'value' => $type === 'percentage' ? $this->faker->numberBetween(5, 50) : $this->faker->numberBetween(10000, 200000),
            'minimum_order_amount' => $this->faker->optional(0.5)->numberBetween(100000, 1000000),
            'usage_limit' => $this->faker->optional(0.5)->numberBetween(10, 1000),
            'uses' => $this->faker->numberBetween(0, 50),
            'starts_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'expires_at' => $this->faker->optional(0.7)->dateTimeBetween('now', '+6 months'),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
