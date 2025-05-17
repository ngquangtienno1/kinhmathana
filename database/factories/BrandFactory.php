<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Brand>
 */
class BrandFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->company();
        return [
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'image' => null,
            'is_active' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}