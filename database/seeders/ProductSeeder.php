<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $categoryIds = Category::pluck('id')->toArray();
        $brandIds = Brand::pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            $importPrice = $faker->randomFloat(2, 10, 200);
            $price = $importPrice + $faker->randomFloat(2, 10, 100);
            $salePrice = $price + $faker->randomFloat(2, 5, 50);
            $discountPrice = $faker->boolean(50) ? $faker->randomFloat(2, 5, $price) : 0;

            Product::create([
                'name' => $faker->words(3, true),
                'description_short' => $faker->sentence(),
                'description_long' => $faker->paragraphs(3, true),
                'price' => $price,
                'import_price' => $importPrice,
                'sale_price' => $salePrice,
                'discount_price' => $discountPrice,
                'category_id' => $faker->optional()->randomElement($categoryIds),
                'brand_id' => $faker->optional()->randomElement($brandIds),
                'status' => $faker->randomElement(['active', 'inactive', 'draft']),
                'is_featured' => $faker->boolean(30), // 30% là nổi bật
                'views' => $faker->numberBetween(0, 1000),
            ]);
        }
    }
}
