<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = $this->faker->company();
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->catchPhrase,
            'logo_path' => $this->faker->imageUrl(200, 100, 'business'),
            'image' => null,
            'is_active' => $this->faker->boolean(80),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}