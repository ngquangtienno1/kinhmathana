<?php

namespace Database\Seeders;
use App\Models\News;
use App\Models\UploadFile;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create();

        $imageIds = UploadFile::pluck('id')->toArray(); // Lấy danh sách ID ảnh có sẵn

        for ($i = 0; $i < 10; $i++) {
            News::create([
                'title' => $faker->sentence(6),
                'content' => $faker->paragraphs(3, true),
                'image_id' => $faker->optional()->randomElement($imageIds), // có thể null
            ]);
        }
    }
}
