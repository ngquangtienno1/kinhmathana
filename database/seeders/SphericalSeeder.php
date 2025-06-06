<?php

namespace Database\Seeders;

use App\Models\Spherical;
use Illuminate\Database\Seeder;

class SphericalSeeder extends Seeder
{
    public function run(): void
    {
        $values = [];
        $value = -0.25;
        $sortOrder = 1;

        while ($value >= -8.00) {
            $values[] = [
                'value' => $value,
                'sort_order' => $sortOrder,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $value -= 0.25;
            $sortOrder++;
        }

        Spherical::insert($values);
    }
}