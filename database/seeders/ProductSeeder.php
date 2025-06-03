<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 5 sản phẩm đơn giản
        Product::factory()
            ->count(5)
            ->state(['product_type' => 'simple'])
            ->create();

        // Tạo 5 sản phẩm có biến thể
        Product::factory()
            ->count(5)
            ->state(['product_type' => 'variable'])
            ->create();
    }
}
