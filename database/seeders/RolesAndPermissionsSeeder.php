<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        // Define modules and actions
        $modules = [
            'users', 'roles', 'permissions', 'aircrafts', 'suppliers', 'shelf-locations', 'locations', 'shelves',
            'rotables', 'consumables', 'esd-items', 'dangerous-goods', 'tyres', 'tools', 'dopes', 'requisitions',
            'goods-received-notes'
        ];

        $actions = ['list', 'create', 'edit', 'delete'];

        // Create permissions
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::create(['name' => $module . '-' . $action]);
            }
        }

        // Add special permissions for requisitions
        Permission::create(['name' => 'requisitions-approve']);
        Permission::create(['name' => 'requisitions-reject']);
        Permission::create(['name' => 'requisitions-disburse']);

        // Add special permissions for Goods Received Notes
        Permission::create(['name' => 'goods-received-notes-approve']);
        Permission::create(['name' => 'goods-received-notes-reject']);

        // Create roles
        $adminRole = Role::create(['name' => 'Admin']);
        $mdRole = Role::create(['name' => 'MD']);
        $storeManagerRole = Role::create(['name' => 'Store-Manager']);
        $technicianRole = Role::create(['name' => 'Technician']);

        // Assign all permissions to Admin
        $adminRole->givePermissionTo(Permission::all());

        // Assign store-related and requisition permissions to MD
        $mdPermissions = [
            'requisitions-list', 'requisitions-approve', 'requisitions-reject',
            'goods-received-notes-list', 'goods-received-notes-approve', 'goods-received-notes-reject'
        ];
        foreach ($mdPermissions as $permission) {
            $mdRole->givePermissionTo($permission);
        }

        // Assign store-related permissions to Store Manager
        $storeModules = [
            'aircrafts', 'suppliers', 'shelf-locations', 'locations', 'shelves', 'rotables', 'consumables',
            'esd-items', 'dangerous-goods', 'tyres', 'tools', 'dopes', 'goods-received-notes'
        ];

        foreach ($storeModules as $module) {
            foreach ($actions as $action) {
                $storeManagerRole->givePermissionTo($module . '-' . $action);
            }
        }
        $storeManagerRole->givePermissionTo('requisitions-list');
        $storeManagerRole->givePermissionTo('requisitions-create');
//        $storeManagerRole->givePermissionTo('requisitions-edit');
        $storeManagerRole->givePermissionTo('requisitions-delete');
        $storeManagerRole->givePermissionTo('requisitions-disburse');

        // Assign view-only permissions to Technician
        foreach ($storeModules as $module) {
            $technicianRole->givePermissionTo($module . '-list');
        }
        $technicianRole->givePermissionTo('requisitions-list');
        $technicianRole->givePermissionTo('requisitions-create');
        $technicianRole->givePermissionTo('requisitions-disburse');


        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@binaniair.com'
        ]);

        $user->assignRole('Admin');

        $user = User::factory()->create([
            'name' => 'Managing Director',
            'email' => 'md@binaniair.com',
            'password' => 'password'
        ]);

        $user->assignRole('MD');

        $user = User::factory()->create([
            'name' => 'Store Manager',
            'email' => 'store@binaniair.com',
            'password' => 'password'
        ]);

        $user->assignRole('Store-Manager');

        $user = User::factory()->create([
            'name' => 'Technician',
            'email' => 'tech@binaniair.com',
            'password' => 'password'
        ]);

        $user->assignRole('Technician');
    }
}
