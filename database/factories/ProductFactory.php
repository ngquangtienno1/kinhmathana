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
        $price = $this->faker->numberBetween(100000, 5000000);
        $hasSale = $this->faker->boolean(30); // 30% cơ hội có giá khuyến mãi

        return [
            'name' => $name,
            'description_short' => $this->faker->sentence,
            'description_long' => $this->faker->paragraph,
            'product_type' => $this->faker->randomElement(['simple', 'variable']),
            'sku' => 'SKU-' . Str::slug($name) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'price' => $price,
            'sale_price' => $hasSale ? $price * 0.9 : null, // Giảm giá 10% nếu có khuyến mãi
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
            // Gắn danh mục cho sản phẩm
            $product->categories()->attach(
                $this->faker->randomElements([1, 2, 3, 4, 5], $this->faker->numberBetween(1, 3))
            );

            // Tạo biến thể nếu là sản phẩm có biến thể
            if ($product->product_type === 'variable') {
                // Lấy tất cả các giá trị có thể có của các thuộc tính
                $colors = Color::all();
                $sizes = Size::all();
                $sphericals = Spherical::all();
                $cylindricals = Cylindrical::all();

                // Số lượng biến thể ngẫu nhiên cho mỗi sản phẩm (từ 2 đến 8 biến thể)
                $numberOfVariations = $this->faker->numberBetween(2, 8);
                $variations = [];
                $variationIndex = 1;

                // Tạo các biến thể ngẫu nhiên
                for ($i = 0; $i < $numberOfVariations; $i++) {
                    // Chọn ngẫu nhiên một giá trị cho mỗi thuộc tính
                    $color = $colors->random();
                    $size = $sizes->random();
                    $spherical = $sphericals->random();
                    $cylindrical = $cylindricals->random();

                    // Tạo tên biến thể từ các thuộc tính đã chọn
                    $variationName = $color->name . ' - ' . $size->name . ' - ' . $spherical->name . ' - ' . $cylindrical->name;
                    $variationSku = $product->sku . '-VAR' . $variationIndex++;
                    
                    // Tạo giá gốc và giá khuyến mãi cho biến thể
                    $variationPrice = $this->faker->numberBetween(100000, 5000000);
                    $hasSale = $this->faker->boolean(30); // 30% cơ hội có giá khuyến mãi
                    $salePrice = $hasSale ? $variationPrice * 0.9 : null; // Giảm giá 10% nếu có khuyến mãi

                    $variations[] = [
                        'name' => $variationName,
                        'sku' => $variationSku,
                        'price' => $variationPrice,
                        'sale_price' => $salePrice,
                        'stock_quantity' => $this->faker->numberBetween(0, 50),
                        'status' => $this->faker->randomElement(['in_stock', 'out_of_stock', 'hidden']),
                        'color_id' => $color->id,
                        'size_id' => $size->id,
                        'spherical_id' => $spherical->id,
                        'cylindrical_id' => $cylindrical->id,
                    ];
                }

                // Tạo các biến thể cho sản phẩm
                $product->variations()->createMany($variations);
            }
        });
    }
}
