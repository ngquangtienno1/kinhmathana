<?php

namespace Database\Factories;

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

        return [
            'user_id'     => User::factory(),
            'entity_type' => $this->faker->randomElement($entityTypes),
            'entity_id'   => $this->faker->numberBetween(1, 50),
            'content'     => $this->faker->paragraph(2),
            'status'      => $this->faker->randomElement($statusList),
            'is_hidden'   => $this->faker->boolean(40), // 40% bị ẩn
        ];
    }
}