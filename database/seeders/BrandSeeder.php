<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Ray-Ban',
                'slug' => 'ray-ban',
                'description' => 'Thương hiệu kính mắt nổi tiếng',
                'is_active' => true
            ],
            [
                'name' => 'Oakley',
                'slug' => 'oakley',
                'description' => 'Kính thể thao cao cấp',
                'is_active' => true
            ],
            [
                'name' => 'Gucci',
                'slug' => 'gucci',
                'description' => 'Thương hiệu thời trang luxury',
                'is_active' => true
            ],
            [
                'name' => 'Prada',
                'slug' => 'prada',
                'description' => 'Kính mắt thời trang cao cấp',
                'is_active' => true
            ],
            [
                'name' => 'Chanel',
                'slug' => 'chanel',
                'description' => 'Thương hiệu thời trang luxury',
                'is_active' => true
            ]
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
