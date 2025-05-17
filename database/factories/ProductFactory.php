<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
            'description_short' => $this->faker->sentence(),
            'description_long' => $this->faker->paragraphs(3, true),
            'price' => $price,
            'import_price' => $this->faker->numberBetween(50000, 2000000),
            'sale_price' => $salePrice,
            'discount_price' => $discountPrice,
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'draft']),
            'is_featured' => $this->faker->boolean(20),
            'views' => $this->faker->numberBetween(0, 1000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}