<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Tạo 5 danh mục cha
        $parentCategories = Category::factory()->count(5)->create();

        // Tạo danh mục con cho một số danh mục cha
        foreach ($parentCategories as $parent) {
            Category::factory()->count(2)->create([
                'parent_id' => $parent->id,
            ]);
        }
    }
}