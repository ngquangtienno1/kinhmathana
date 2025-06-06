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
            'value' => $this->faker->unique()->randomFloat(2, -8.00, -0.25),
            'sort_order' => 0,
        ];
    }
}