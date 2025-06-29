<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Variation;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo user mẫu nếu chưa có
        $user = User::first() ?? User::factory()->create();

        // Tạo 3 sản phẩm mẫu
        $products = Product::factory()->count(3)->create();

        foreach ($products as $product) {
            // Tạo variation cho mỗi sản phẩm
            $variation = Variation::factory()->create([
                'product_id' => $product->id,
            ]);

            // Thêm vào giỏ hàng
            Cart::create([
                'user_id' => $user->id,
                'variation_id' => $variation->id,
                'quantity' => rand(1, 5),
            ]);
        }
    }
}
