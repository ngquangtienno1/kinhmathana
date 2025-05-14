<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'title' => 'Khuyến mãi mùa hè',
                'subtitle' => 'Giảm giá lên đến 50%',
                'image' => 'sliders/summer-sale.jpg',
                'link' => '/promotions/summer-sale',
                'order' => 1,
                'is_active' => true
            ],
            [
                'title' => 'Bộ sưu tập mới',
                'subtitle' => 'Xu hướng 2024',
                'image' => 'sliders/new-collection.jpg',
                'link' => '/collections/2024',
                'order' => 2,
                'is_active' => true
            ],
            [
                'title' => 'Gọng kính cao cấp',
                'subtitle' => 'Thương hiệu nổi tiếng',
                'image' => 'sliders/luxury-frames.jpg',
                'link' => '/products/luxury-frames',
                'order' => 3,
                'is_active' => true
            ]
        ];

        foreach ($sliders as $slider) {
            Slider::create($slider);
        }
    }
}