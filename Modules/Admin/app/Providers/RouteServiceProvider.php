<?php

namespace Modules\Admin\Providers;

use Modules\Admin\Middleware\HandleAdminRoutesInertiaRequests;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')->group(module_path('Admin', '/routes/web.php'));
        Route::middleware(['web',HandleAdminRoutesInertiaRequests::class])->prefix('admin')->name('adminWeb.')->group(module_path('Admin', '/routes/webAdmin.php'));

    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware('api')->prefix('api')->name('api.')->group(module_path('Admin', '/routes/api.php'));
        Route::middleware('api')->prefix('adminApi')->name('adminApi.')->group(module_path('Admin', '/routes/apiAdmin.php'));

    }
}
