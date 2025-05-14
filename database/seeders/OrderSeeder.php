<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Generator as Faker;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = app(Faker::class);

        foreach (range(1, 20) as $i) {
            DB::table('orders')->insert([
                'user_id' => 1,
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'shipping_address' => $faker->address,
                'total_amount' => $faker->randomFloat(2, 100, 1000),
                'created_at' => now(),
                'updated_at' => now(),
            ]);


        }
    }
}
