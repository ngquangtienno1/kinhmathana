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
        $name = $this->faker->words(3, true);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'sku' => 'PRD-' . $this->faker->unique()->numberBetween(10000, 99999),
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->numberBetween(100000, 5000000),
            'sale_price' => $this->faker->optional(0.3)->numberBetween(50000, 4000000),
            'stock' => $this->faker->numberBetween(0, 100),
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
            'is_active' => $this->faker->boolean(80),
            'is_featured' => $this->faker->boolean(20),
            'meta_title' => $this->faker->words(4, true),
            'meta_description' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
