<?php

namespace Modules\Main\Providers;


use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;
use Modules\Main\Class\ModulesInertiaSource;

class ModulesInertiaServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->registerPublishing();
        }
        $this->bootingResource();
    }

    protected function registerPublishing(): void
    {
        $this->publishes([
            __DIR__ . "/../config/config.php" => config_path("modules.php")
        ], "config");
    }

    protected function bootingResource(): void
    {
        Inertia::macro('module', function ($view, $args = []) {
            return Inertia::render((new ModulesInertiaSource())->build($view), $args);
        });
    }
}
