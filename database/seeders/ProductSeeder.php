<?php
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Brand;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::factory()->count(50)->create();
    }
}