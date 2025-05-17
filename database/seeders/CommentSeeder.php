<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\News;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = \Faker\Factory::create();

        $users = User::pluck('id')->all();
        $newsItems = News::pluck('id')->all();
        $products = Product::pluck('id')->all();

        // Tổng số comment muốn tạo
        $totalComments = 50;

        for ($i = 0; $i < $totalComments; $i++) {
            // Random entity type và ID tương ứng
            $type = $faker->randomElement(['news', 'product']);
            $entityId = $type === 'news'
                ? $faker->randomElement($newsItems)
                : $faker->randomElement($products);

            Comment::create([
                'user_id' => $faker->randomElement($users),
                'entity_type' => $type,
                'entity_id' => $entityId,
                'content' => $faker->paragraph(),
            ]);
        }
    }
}
