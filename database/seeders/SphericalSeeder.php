<?php

namespace Database\Seeders;

use App\Models\Spherical;
use Illuminate\Database\Seeder;

class SphericalSeeder extends Seeder
{
    public function run()
    {
        $values = [
            ['name' => '0.25', 'sort_order' => 1],
            ['name' => '0.50', 'sort_order' => 2],
            ['name' => '0.75', 'sort_order' => 3],
            ['name' => '1.00', 'sort_order' => 4],
            // ... thêm các giá trị khác
        ];
        foreach ($values as $value) {
            Spherical::create($value);
        }
    }
}