<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            ['name' => 'Main Hangar'],
            ['name' => 'Warehouse A'],
            ['name' => 'Warehouse B'],
            ['name' => 'Engine Shop'],
            ['name' => 'Avionics Lab'],
        ];

        foreach ($locations as $location) {
            Location::create($location);
        }
    }
}
