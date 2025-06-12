<?php

namespace Database\Factories;

use App\Models\Spherical;
use Illuminate\Database\Eloquent\Factories\Factory;

class SphericalFactory extends Factory
{
    protected $model = Spherical::class;

    public function definition(): array
    {
        return [
            'name' => (string) $this->faker->unique()->randomFloat(2, 0.25, 8.00),
            'sort_order' => 0,
        ];
    }
}