<?php

namespace Database\Seeders;

use App\Models\CancellationReason;
use Illuminate\Database\Seeder;

class CancellationReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CancellationReason::factory()->count(10)->create();
    }
}
