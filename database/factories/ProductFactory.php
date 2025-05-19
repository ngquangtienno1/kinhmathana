<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $price = $this->faker->numberBetween(100000, 5000000);
        $salePrice = $this->faker->boolean(30)
            ? $this->faker->numberBetween(50000, $price - 10000)
            : $price;
        $discountPrice = $this->faker->boolean(20)
            ? $this->faker->numberBetween(10000, min($salePrice - 10000, 1000000))
            : 0;

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