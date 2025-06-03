<?php

namespace Database\Seeders;

use App\Models\CustomerSupport;
use Illuminate\Database\Seeder;

class CustomerSupportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerSupport::factory()->count(20)->create();
    }
}
