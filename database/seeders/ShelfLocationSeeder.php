<?php

namespace Database\Seeders;

use App\Models\ShelfLocation;
use Illuminate\Database\Seeder;

class ShelfLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShelfLocation::factory()->count(10)->create();
    }
}
