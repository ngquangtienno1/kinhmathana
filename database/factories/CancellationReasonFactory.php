<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CancellationReason>
 */
class CancellationReasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reason' => $this->faker->sentence(),
            'type' => $this->faker->randomElement(['customer', 'admin']),
            'is_active' => $this->faker->boolean(60),
        ];
    }
}
