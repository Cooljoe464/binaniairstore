<?php

namespace Database\Seeders;

use App\Models\DangerousGood;
use Illuminate\Database\Seeder;

class DangerousGoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DangerousGood::factory()->count(50)->create();
    }
}
