<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define models for which to create permissions
        $models = [
            'user',
            'role',
            'aircraft',
            'supplier',
            'shelf-location',
            'rotable',
            'consumable',
            'esd-item',
            'dangerous-good',
            'tyre',
            'tool',
            'dope',
        ];

        // Define actions
        $actions = ['view', 'create', 'edit', 'delete'];

        // Create permissions for each model and action
        foreach ($models as $model) {
            foreach ($actions as $action) {
                Permission::create(['name' => "{$model}-{$action}"]);
            }
        }

        // Create an Admin role and assign all permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Create a Store Manager role and assign inventory management permissions
        $storeManagerRole = Role::create(['name' => 'Store-Manager']);
        $storeManagerPermissions = Permission::where(function ($query) {
            $query->where('name', 'not like', 'user-%')
                  ->where('name', 'not like', 'role-%');
        })->get();
        $storeManagerRole->givePermissionTo($storeManagerPermissions);

        // Create a User role and assign view-only permissions for inventory
        $userRole = Role::create(['name' => 'User']);
        $userPermissions = Permission::where(function ($query) {
            $query->where('name', 'like', '%-view')
                  ->where('name', 'not like', 'user-%')
                  ->where('name', 'not like', 'role-%');
        })->get();
        $userRole->givePermissionTo($userPermissions);
    }
}
