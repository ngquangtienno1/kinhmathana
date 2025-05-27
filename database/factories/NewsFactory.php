<?php

namespace Database\Factories;

use App\Models\NewsCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence();
        return [
            'category_id' => NewsCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'summary' => $this->faker->paragraph(),
            'content' => $this->faker->paragraphs(5, true),
            'image' => null, // We'll handle image uploads separately
            'author_id' => User::factory(),
            'is_active' => true,
            'published_at' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
        ];
    }
}