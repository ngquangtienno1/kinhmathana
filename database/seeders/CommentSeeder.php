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
        // Kiểm tra xem có dữ liệu news và products chưa
        if (News::count() === 0) {
            News::factory()->count(10)->create();
        }
        if (Product::count() === 0) {
            Product::factory()->count(10)->create();
        }

        Comment::factory()->count(20)->create();
    }
}
