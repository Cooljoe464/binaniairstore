<?php

namespace Database\Seeders;

use App\Models\Dope;
use Illuminate\Database\Seeder;

class DopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dope::factory()->count(50)->create();
    }
}
