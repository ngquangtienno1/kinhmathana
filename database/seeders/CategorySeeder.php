<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kính cận',
                'description' => 'Các loại kính dành cho người cận thị',
                'parent_id' => null
            ],
            [
                'name' => 'Kính râm',
                'description' => 'Các loại kính chống nắng, tia UV',
                'parent_id' => null
            ],
            [
                'name' => 'Kính thời trang',
                'description' => 'Các loại kính thời trang',
                'parent_id' => null
            ],
            [
                'name' => 'Tròng kính',
                'description' => 'Các loại tròng kính',
                'parent_id' => null
            ],
            [
                'name' => 'Phụ kiện',
                'description' => 'Phụ kiện kính mắt',
                'parent_id' => null
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'parent_id' => $category['parent_id']
                ]
            );
        }
    }
}
