<?php

namespace Database\Factories;

use App\Models\Size;

use App\Models\Color;
use App\Models\Product;
use App\Models\Spherical;
use App\Models\Cylindrical;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'name' => $name,
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(100000, 1000000),
            'status' => 'Hoạt động',
            'product_type' => $this->faker->randomElement(['simple', 'variable']),
            'slug' => Str::slug($name . '-' . $this->faker->unique()->numberBetween(1000, 9999)),
            'sku' => 'PROD-' . $this->faker->unique()->numberBetween(10000, 99999),
            'quantity' => $this->faker->numberBetween(0, 100),
            'sale_price' => $this->faker->optional()->numberBetween(80000, 900000),
            'brand_id' => null, // Gán brand sau nếu cần
            'is_featured' => $this->faker->boolean(20),
            'views' => $this->faker->numberBetween(0, 1000),
            'video_path' => null,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            // Gắn danh mục cho sản phẩm
            $product->categories()->attach(
                $this->faker->randomElements([1, 2, 3, 4, 5], $this->faker->numberBetween(1, 3))
            );
            // Gắn tag cho sản phẩm nếu có
            if (\App\Models\Tag::count() > 0) {
                $product->tags()->attach(
                    $this->faker->randomElements(\App\Models\Tag::pluck('id')->toArray(), $this->faker->numberBetween(1, 3))
                );
            }
            // Gắn brand nếu có
            if (\App\Models\Brand::count() > 0) {
                $product->brand_id = \App\Models\Brand::inRandomOrder()->first()->id;
                $product->save();
            }
            // Tạo biến thể nếu là sản phẩm có biến thể
            if ($product->product_type === 'variable') {
                $colors = Color::all();
                $sizes = Size::all();
                $sphericals = Spherical::all();
                $cylindricals = Cylindrical::all();
                $numberOfVariations = $this->faker->numberBetween(3, 8);
                $variations = [];
                for ($i = 0; $i < $numberOfVariations; $i++) {
                    $color = $colors->random();
                    $size = $sizes->random();
                    $spherical = $sphericals->random();
                    $cylindrical = $cylindricals->random();
                    $variationName = $color->name . ' - ' . $size->name . ' - ' . $spherical->name . ' - ' . $cylindrical->name;
                    $variationSku = 'VAR-' . $this->faker->unique()->numberBetween(100000, 999999);
                    $variationPrice = $this->faker->numberBetween(100000, 5000000);
                    $hasSale = $this->faker->boolean(30);
                    $salePrice = $hasSale ? $variationPrice * 0.9 : null;
                    $variations[] = [
                        'name' => $variationName,
                        'sku' => $variationSku,
                        'price' => $variationPrice,
                        'import_price' => $variationPrice * 0.7,
                        'sale_price' => $salePrice,
                        'discount_price' => $hasSale ? $variationPrice * 0.85 : null,
                        'quantity' => $this->faker->numberBetween(0, 50),
                        'status' => $this->faker->randomElement(['active', 'in_stock', 'out_of_stock', 'hidden']),
                        'color_id' => $color->id,
                        'size_id' => $size->id,
                        'spherical_id' => $spherical->id,
                        'cylindrical_id' => $cylindrical->id,
                    ];
                }
                $product->variations()->createMany($variations);
            }
        });
    }
}
