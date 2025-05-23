<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $faker = Faker::create();

        $userIds = User::pluck('id')->all();

        if (count($userIds) === 0) {
            User::factory()->count(5)->create();
            $userIds = User::pluck('id')->all();
        }

        $priorities = ['thấp', 'trung bình', 'cao'];
        $statuses = ['mới', 'đang xử lý', 'chờ khách', 'đã đóng'];

        for ($i = 0; $i < 50; $i++) {
            Ticket::create([
                'title' => $faker->sentence(6),
                'description' => $faker->paragraph,
                'status' => $faker->randomElement($statuses),
                'priority' => $faker->randomElement($priorities),
                'user_id' => $faker->randomElement($userIds),
                'assigned_to' => $faker->randomElement($userIds),
                'created_at' => $faker->dateTimeBetween('-1 month'),
                'updated_at' => now(),
            ]);
        }
    }

}
