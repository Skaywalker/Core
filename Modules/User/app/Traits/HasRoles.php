<?php

namespace Modules\User\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\User\Models\User;

trait HasRoles
{
    /**
     * A user may have multiple roles.
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_user');
    }
    /**
     * AssignRole the given role to the user.
     * @param string $role
     * @return Collection
     **/
    public function assignRole(string $roleSlug):Role
    {
        return $this->roles()->save(
            Role::where('slug',$roleSlug)->firstOrFail()
        );
    }
    /**
     * Determine if the user has the given role.
     * @param mixed $role
     * @return bool
     **/
    public function hasRole(mixed $role):bool
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }
    /**
     * Determine if the user may perform the given permission.
     * @param Permission $permission
     * @return bool
     **/
    public function hasPermission(Permission $permission):bool
    {

        return $this->hasRole($permission->permissionToRole);
    }
    /**
     * Get the user roles and permissions.
     * @return Collection
     **/
    public function getRoleAndPermission():Collection{
        return $this->roles()->with('permissions')->get();
    }
}
