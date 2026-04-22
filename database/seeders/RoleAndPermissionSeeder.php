<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage categories']);
        Permission::create(['name' => 'manage products']);
        Permission::create(['name' => 'manage exchanges']);
        Permission::create(['name' => 'create products']);
        Permission::create(['name' => 'view products']);
        Permission::create(['name' => 'propose exchanges']);

        // Create roles
        $admin = Role::create(['name' => 'Admin']);
        $seller = Role::create(['name' => 'Seller']);
        $customer = Role::create(['name' => 'Customer']);

        // Assign permissions to roles
        $admin->givePermissionTo(Permission::all());

        $seller->givePermissionTo(['create products', 'manage products', 'view products', 'propose exchanges']);

        $customer->givePermissionTo(['view products', 'propose exchanges']);
    }
}
