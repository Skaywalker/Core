<?php

namespace Modules\Main\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as IlluminateAuthServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Modules\User\Models\Permission;

class AuthServiceProvider extends IlluminateAuthServiceProvider
{
    /**
     * Register the service provider.
     */
   public function boot(Gate $gate): void
   {
       if ($this->getPermissionsExit()){
           foreach ($this->getPermissions() as $permission){
               $gate::define($permission->slug, function ($user) use ($permission){
                   return $user->hasRole($permission->permissionToRole);
               });
           }
       }
   }
    protected function getPermissions(): \Illuminate\Database\Eloquent\Collection
    {
        return Permission::with('permissionToRole')->get();
    }
    protected function getPermissionsExit(): bool
    {
        return Schema::hasTable('permissions');

    }
}
