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

        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Assign a default role to the test user
        $user->assignRole('Admin');

        $this->call([
            AircraftSeeder::class,
            SupplierSeeder::class,
            ShelfLocationSeeder::class,
            RotableSeeder::class,
            ConsumableSeeder::class,
            EsdItemSeeder::class,
            DangerousGoodSeeder::class,
            TyreSeeder::class,
            ToolSeeder::class,
            DopeSeeder::class,
        ]);
    }
}
