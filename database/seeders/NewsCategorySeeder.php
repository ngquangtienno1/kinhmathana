<?php

namespace Database\Seeders;

use App\Models\NewsCategory;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Tin tức công nghệ',
                'slug' => 'tin-tuc-cong-nghe',
                'description' => 'Cập nhật tin tức mới nhất về công nghệ',
                'is_active' => true,
            ],
            [
                'name' => 'Khuyến mãi',
                'slug' => 'khuyen-mai',
                'description' => 'Thông tin về các chương trình khuyến mãi',
                'is_active' => true,
            ],
            [
                'name' => 'Sự kiện',
                'slug' => 'su-kien',
                'description' => 'Thông tin về các sự kiện sắp diễn ra',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            NewsCategory::create($category);
        }
    }
}
