<?php

namespace Database\Factories;

use App\Models\News;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    public function definition(): array
    {
        $entityTypes = ['news', 'product'];
        $statusList = ['chờ duyệt', 'đã duyệt', 'spam', 'chặn'];
        $entityType = $this->faker->randomElement($entityTypes);

        // Lấy ID thực tế từ bảng tương ứng
        $entityId = match ($entityType) {
            'news' => News::inRandomOrder()->first()?->id ?? 1,
            'product' => Product::inRandomOrder()->first()?->id ?? 1,
            default => 1,
        };

        return [
            'user_id'     => User::factory(),
            'entity_type' => $entityType,
            'entity_id'   => $entityId,
            'content'     => $this->faker->paragraph(2),
            'status'      => $this->faker->randomElement($statusList),
            'is_hidden'   => $this->faker->boolean(40), // 40% bị ẩn
        ];
    }
}
