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
            'name' => (string) $this->faker->unique()->randomFloat(2, 0.25, 4.00),
            'sort_order' => 0,
        ];
    }
}
