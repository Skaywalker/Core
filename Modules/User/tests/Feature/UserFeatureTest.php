<?php

namespace Modules\User\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Modules\User\Console\CrateSuperAdmin;
use Modules\User\Database\Factories\AdminUserFactoryFactory;
use Modules\User\Database\Factories\RoleFactory;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\User;
use Tests\TestCase;

class UserFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected string$superAdminEmail='Admin123456';
    protected string$superAdminPassword='email@email.com';
    protected string$roleSlug='admin';
    protected string$permissionSlug='admin';

    protected function setUp(): void
    {
        parent::setUp();
        RoleFactory::new([
            'slug'=>$this->roleSlug,
            'label'=>'Admin Role',
        ])->create();
        Permission::create([
            'slug'=>$this->permissionSlug,
            'label'=>'Admin',
            'description'=>'Admin'
        ]);
        AdminUserFactoryFactory::new()->withEmail($this->superAdminEmail)->withPassword($this->superAdminPassword)->create();
    }
    /**
     * A basic unit test example.
     *
     */
    public function test_User_table_has_exists(): void
    {
        $this->assertTrue(Schema::hasTable('users'),'Users Table is not found');
    }
    public function test_create_super_admin()
    {
        $user=User::where('email',$this->superAdminEmail)->first();
        $this->assertSame($user->email,$this->superAdminEmail);
    }
    public function test_create_roles()
    {
        $slug='admin';
        $role=Role::where('slug',$this->roleSlug)->first();
        $this->assertSame($role->slug,$slug);
    }
    public function test_crate_permission()
    {

        $query=Permission::where('slug',$this->permissionSlug)->first();
        $this->assertSame($query->slug,$this->permissionSlug);
    }
    public function test_crate_permission_to_role()
    {
        $role=Role::where('slug',$this->roleSlug)->first();
        $per=Permission::where('slug',$this->permissionSlug)->first();
        $role->givePermissionTo($per);
        $this->assertSame($role->rolesToPermission()->first()->slug,$per->slug);
    }
    public function test_add_role_to_user()
    {
        $user=User::where('email',$this->superAdminEmail)->first();
        $role=Role::where('slug',$this->roleSlug)->first();
        $user->assignRole($role->slug);
        $this->assertTrue($user->roles->contains($role));
    }
    public function test_user_hasRole()
    {
        $user=User::where('email',$this->superAdminEmail)->first();
        $role=Role::where('slug',$this->roleSlug)->first();
        $user->assignRole($role->slug);
        $this->assertTrue($user->hasRole($this->roleSlug));
    }
    public function test_user_hasPermission()
    {
        $user=User::where('email',$this->superAdminEmail)->first();
        $role=Role::where('slug',$this->roleSlug)->first();
        $per=Permission::where('slug',$this->permissionSlug)->first();
        $role->givePermissionTo($per);
        $user->assignRole($role->slug);
        $this->assertTrue($user->hasRole($this->roleSlug));
        $this->assertTrue($user->hasPermission($per));
    }
    public function test_hasGatePermission()
    {
        $user=User::where('email',$this->superAdminEmail)->first();
        $role=Role::where('slug',$this->roleSlug)->first();
        $per=Permission::where('slug',$this->permissionSlug)->first();
        $role->givePermissionTo($per);
        $user->assignRole($role->slug);
        Gate::define($this->permissionSlug, function ($user) use ($per) {
            return $user->hasRole($per->permissionToRole);
        });
        $this->assertTrue(Gate::has($this->permissionSlug));
    }
}
