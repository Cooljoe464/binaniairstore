<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        $storeManagerRole = Role::create(['name' => 'Store-Manager']);
        $technicianRole = Role::create(['name' => 'Technician']);

        // Assign all permissions to Admin
        $adminRole->givePermissionTo(Permission::all());

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
    }
}
