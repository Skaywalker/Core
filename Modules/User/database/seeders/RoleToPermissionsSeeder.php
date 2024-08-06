<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;

class RoleToPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the admin role
        $adminRole = Role::where('slug', 'admin')->first();

        // Get the admin permission
        $adminPermission = Permission::where('slug', 'admin')->first();

        // Attach the admin permission to the admin role
        $adminRole->rolesToPermission()->attach($adminPermission);
    }
}
