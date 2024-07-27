<?php

namespace Modules\User\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\User\Database\Factories\PermissionFactory;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'slug',
        'label',
        'description',
    ];

    protected static function newFactory(): PermissionFactory
    {
        return PermissionFactory::new();
    }
    public function permissionToRole(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'permission_roles');
    }
}
