<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo tài khoản admin mặc định
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'address' => '123 Admin Street',
            'phone' => '0123456789',
            'date_birth' => '1990-01-01',
            'gender' => 'male',
            'status_user' => 'active',
            'role_id' => 1, // Admin role
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);

        // Tạo tài khoản nhân viên mặc định
        User::create([
            'name' => 'Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'address' => '456 Staff Street',
            'phone' => '0987654321',
            'date_birth' => '1995-01-01',
            'gender' => 'female',
            'status_user' => 'active',
            'role_id' => 2, // Staff role
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);

        // Tạo thêm 20 tài khoản ngẫu nhiên
        User::factory()->count(20)->create([
            'role_id' => 3, // Customer role
            'status_user' => 'active',
        ]);
    }
}