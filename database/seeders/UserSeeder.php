<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Test User',
            'email' => 'testcsd2345@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role_id' => 1, // Thêm dòng này để tránh lỗi
        ]);
    }
}
