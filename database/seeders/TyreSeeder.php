<?php

namespace Database\Seeders;

use App\Models\Tyre;
use Illuminate\Database\Seeder;

class TyreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tyre::factory()->count(50)->create();
    }
}
