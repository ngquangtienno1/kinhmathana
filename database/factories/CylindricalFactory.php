<?php

namespace Database\Factories;

use App\Models\Cylindrical;
use Illuminate\Database\Eloquent\Factories\Factory;

class CylindricalFactory extends Factory
{
    protected $model = Cylindrical::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->unique()->randomFloat(2, -4.00, -0.25),
            'sort_order' => 0,
        ];
    }
}
