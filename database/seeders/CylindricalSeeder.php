<?php

namespace Database\Seeders;

use App\Models\Cylindrical;
use Illuminate\Database\Seeder;

class CylindricalSeeder extends Seeder
{
    public function run(): void
    {
        $values = [];
        $value = -0.25;
        $sortOrder = 1;

        while ($value >= -4.00) {
            $values[] = [
                'value' => $value,
                'sort_order' => $sortOrder,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $value -= 0.25;
            $sortOrder++;
        }

        Cylindrical::insert($values);
    }
}