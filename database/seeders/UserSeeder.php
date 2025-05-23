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
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => 1, // Admin role
            'status_user' => 'active',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);

        // Create staff users
        User::factory()->count(5)->create([
            'role_id' => 2, // Staff role
            'status_user' => 'active',
        ]);

        // Create regular users (customers)
        User::factory()->count(20)->create([
            'role_id' => 3, // Customer role
            'status_user' => 'active',
        ]);
    }
}
