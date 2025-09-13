<?php

namespace Database\Seeders;

use App\Models\Rotable;
use Illuminate\Database\Seeder;

class RotableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rotable::factory()->count(50)->create();
    }
}
