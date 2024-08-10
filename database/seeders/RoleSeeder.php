<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $permissions = Permission::all();

        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->permissions()->attach($permissions);

        $vendorRole = Role::create(['name' => 'Vendor']);
        $vendorRole->permissions()->attach($permissions->whereIn('name', ['view_orders']));

        $clientRole = Role::create(['name' => 'Client']);
        $clientRole->permissions()->attach($permissions->whereIn('name', ['view_orders']));
    }
}
