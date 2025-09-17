<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role; // <--- CORRECTED
use App\Models\Permission; // <--- CORRECTED

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Define modules and actions
        $modules = [
            'users', 'roles', 'permissions', 'aircrafts', 'suppliers', 'shelf-locations',
            'rotables', 'consumables', 'esd-items', 'dangerous-goods', 'tyres', 'tools', 'dopes'
        ];

        $actions = ['list', 'create', 'edit', 'delete'];

        // Create permissions
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::create(['name' => $module . '-' . $action]);
            }
        }

        // Create roles
        $adminRole = Role::create(['name' => 'Admin']);
        $MdRole = Role::create(['name' => 'MD']);
        $storeManagerRole = Role::create(['name' => 'Store-Manager']);
        $technicianRole = Role::create(['name' => 'Technician']);

        // Assign all permissions to Admin
        $adminRole->givePermissionTo(Permission::all());
        $MdRole->givePermissionTo(Permission::all());

        // Assign store-related permissions to Store Manager
        $storeModules = [
            'aircrafts', 'suppliers', 'shelf-locations', 'rotables', 'consumables',
            'esd-items', 'dangerous-goods', 'tyres', 'tools', 'dopes'
        ];

        foreach ($storeModules as $module) {
            foreach ($actions as $action) {
                $storeManagerRole->givePermissionTo($module . '-' . $action);
            }
        }

        // Assign view-only permissions to Technician
        foreach ($storeModules as $module) {
            $technicianRole->givePermissionTo($module . '-list');
        }


        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@binaniair.com'
        ]);

        $user->assignRole('Admin');
    }
}
