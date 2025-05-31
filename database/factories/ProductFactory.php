<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);

        return [
            'name' => $name,
            'description_short' => $this->faker->sentence,
            'description_long' => $this->faker->paragraph,
            'product_type' => $this->faker->randomElement(['simple', 'variable']),
            'sku' => 'SKU-' . Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'slug' => Str::slug($name . '-' . time()),
            'brand_id' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['Hoạt động', 'Không hoạt động']),
            'is_featured' => $this->faker->boolean,
            'views' => $this->faker->numberBetween(0, 1000),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Gắn danh mục (categories) cho sản phẩm (quan hệ nhiều-nhiều)
            $product->categories()->attach(
                $this->faker->randomElements([1, 2, 3, 4, 5], $this->faker->numberBetween(1, 3))
            );

            // Tạo biến thể nếu là sản phẩm có biến thể
            if ($product->product_type === 'variable') {
                $colors = ['Đen', 'Nâu', 'Trong suốt', 'Vàng gold'];
                $sizes = ['48–50mm', '51–54mm', '55mm ⬆️'];
                $variations = [];
                $variationIndex = 1;

                foreach ($colors as $colorName) {
                    foreach ($sizes as $sizeName) {
                        $variationName = "$colorName - $sizeName";
                        $variationSku = $product->sku . '-VAR' . $variationIndex++;
                        $variationPrice = $this->faker->numberBetween(100000, 5000000);

                        // Tìm hoặc tạo color và size
                        $color = Color::firstOrCreate(['name' => $colorName]);
                        $size = Size::firstOrCreate(['name' => $sizeName]);

                        $variations[] = [
                            'name' => $variationName,
                            'sku' => $variationSku,
                            'price' => $variationPrice,
                            'sale_price' => $this->faker->boolean(30) ? $variationPrice * 0.9 : null,
                            'stock_quantity' => $this->faker->numberBetween(0, 50),
                            'status' => $this->faker->randomElement(['in_stock', 'out_of_stock', 'hidden']),
                            'color_id' => $color->id,
                            'size_id' => $size->id,
                        ];
                    }
                }

                $product->variations()->createMany($variations);
            }
        });
    }
}