<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description_short' => $this->faker->sentence,
            'description_long' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 100, 500),
            'import_price' => $this->faker->randomFloat(2, 50, 400),
            'sale_price' => $this->faker->randomFloat(2, 80, 450),
            'category_id' => 1, // tạo sẵn category id để tránh lỗi
            'brand_id' => 1,
            'status' => 'active',
            'is_featured' => $this->faker->boolean,
            'views' => $this->faker->numberBetween(0, 1000),
        ];
    }
}
