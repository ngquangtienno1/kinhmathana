<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Quản trị viên hệ thống'
            ],
            [
                'name' => 'User',
                'description' => 'Người dùng thông thường'
            ],
            [
                'name' => 'Staff',
                'description' => 'Nhân viên'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
