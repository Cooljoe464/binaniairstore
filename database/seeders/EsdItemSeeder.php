<?php

namespace Database\Seeders;

use App\Models\EsdItem;
use Illuminate\Database\Seeder;

class EsdItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EsdItem::factory()->count(50)->create();
    }
}
