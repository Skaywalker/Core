<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'slug',
        'label',
    ];

    protected static function newFactory(): RoleFactory
    {
        return RoleFactory::new();
    }
    /**
     * The roles that belong to the permission.
     * @return BelongsToMany
     **/
    public function rolesToPermission(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_roles');
    }
    /**
     * Give permission to a role.
     * @param Permission $permission
     * @return Permission
     **/
    public function givePermissionTo(Permission $permission): Permission
    {
        return $this->rolesToPermission()->save($permission);
    }
}
