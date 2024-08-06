<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'slug' => 'admin',
            'label' => 'admin',
            'description' => 'This permission allows the user to access the admin panel.',
        ]);
    }
}
