<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // It's best to run the Role & Permission seeder first
        $this->call(RolesAndPermissionsSeeder::class);


        $this->call([
            AircraftSeeder::class,
            SupplierSeeder::class,
            ShelfLocationSeeder::class,
            LocationSeeder::class, // Added Location Seeder
            RotableSeeder::class,
            ConsumableSeeder::class,
            EsdItemSeeder::class,
            DangerousGoodSeeder::class,
            TyreSeeder::class,
            ToolSeeder::class,
            DopeSeeder::class,
//            RequisitionSeeder::class,
        ]);
    }
}
