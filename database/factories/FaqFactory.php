<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->paragraph(),
            'image' => null,
            'images' => null,
            'rating' => $this->faker->randomFloat(2, 0, 5),
            'rating_count' => $this->faker->numberBetween(0, 50),
            'category' => $this->faker->randomElement(['Chung', 'Sản phẩm', 'Vận chuyển', 'Thanh toán', 'Bảo hành']),
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => true
        ];
    }
}
