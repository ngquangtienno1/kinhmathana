<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
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
        // Lấy role Admin
        $adminRole = Role::where('name', 'Admin')->first();
        $userRole = Role::where('name', 'User')->first();

        // Tạo tài khoản admin
        User::create([
            'name' => 'Admin',
            'email' => 'tiennqph51552@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'role_id' => $adminRole->id
        ]);

        // Tạo 10 người dùng mẫu với role User
        User::factory()->count(10)->create([
            'role_id' => $userRole->id
        ]);
        
    }
}
