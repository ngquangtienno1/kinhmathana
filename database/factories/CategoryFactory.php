<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->words(2, true); // Tạo tên ngẫu nhiên gồm 2 từ
        return [
            'name' => $name,
            'slug' => Str::slug($name), // Tạo slug từ name
            'description' => $this->faker->sentence(10), // Tạo mô tả ngẫu nhiên
            'parent_id' => null, // Để trống hoặc bạn có thể thêm logic để tạo danh mục con
            'is_active' => $this->faker->boolean(),
        ];
    }
}
