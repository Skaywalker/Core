<?php

namespace Modules\Main\Providers;

use Illuminate\Support\Collection;
use Modules\Admin\Http\Middleware\HandleAdminInertiaRequests;
use Modules\Admin\Providers\AdminServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Testing\TestResponse;
use Illuminate\View\FileViewFinder;
use LogicException;
use Modules\Main\Console\BCMSAdminRouteGenerate;
use Modules\Main\Console\bMigrate;
use Modules\Main\Console\BMigrateSeed;
use Modules\Main\Console\BMigrateSeedKeep;
use Modules\Main\Testing\TestResponseModularMacros;
use Illuminate\Foundation\Testing\TestResponse as LegacyTestResponse;
use Modules\User\Providers\FortifyServiceProvider;
use Modules\Website\Providers\WebsiteServiceProvider;
use Modules\User\Providers\UserServiceProvider;

class MainServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Main';

    protected string $moduleNameLower = 'main';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerCommands();
        $this->registerCommandSchedules();
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
        $this->registerTestingMacros();
        $middlewareGroups = $this->getMiddlewareGroups();
        $middlewareGroups->map(function($middlewareGroup , $key){

            $this->app['router']->middlewareGroup($key,$middlewareGroup );
        });

    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(provider: \Modules\Main\Providers\ModulesInertiaServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(provider: AuthServiceProvider::class);
        $this->app->register(provider:  FortifyServiceProvider::class);
        $this->app->register(provider:   WebsiteServiceProvider::class);
        $this->app->register(provider:   AdminServiceProvider::class);
        $this->app->register(provider:   UserServiceProvider::class);
        $this->app->bind('inertia.testing.module-view-finder',
            function ($app,$params=null){
                $moduleName = $params['moduleName'] ?? null;

                return new FileViewFinder(
                    $app['files'],
                    [module_path($moduleName, config('modules.paths.source'))],
                    $app['config']->get('main.inertiaModules.testing.page_extensions')
                );
            }
        );
    }

    /**
     * Register commands in the format of Command::class
     */
    protected function registerCommands(): void
    {
        $this->commands([
            bMigrate::class,
            BMigrateSeed::class,
            BMigrateSeedKeep::class,
            BCMSAdminRouteGenerate::class,
        ]);
    }

    /**
     * Register command Schedules.
     */
    protected function registerCommandSchedules(): void
    {
        // $this->app->booted(function () {
        //     $schedule = $this->app->make(Schedule::class);
        //     $schedule->command('inspire')->hourly();
        // });
    }

    /**
     * Register translations.
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/'.$this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'resources/lang'),
                $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(module_path($this->moduleName, 'resources/lang'));
        }
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower.'.php')], 'config');

        $configPath = module_path($this->moduleName, 'config');

        // Get all the files in the config directory
        $files = glob($configPath . '/*.php');

        foreach ($files as $file) {
            // Get the base name of the file
            $fileName = basename($file, '.php');

            // Define the key for the config file
            $configKey = $this->moduleNameLower . '.' . $fileName;

            // Define the path for the published config file
            $publishPath = config_path($configKey . '.php');

            // Publish the config file
            $this->publishes([$file => $publishPath], 'config');

            // Merge the config file
            $this->mergeConfigFrom($file, $configKey);
            }
        $this->mergeConfigFrom(module_path($this->moduleName, 'config/config.php'), $this->moduleNameLower);
    }

    /**
     * Register views.
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/'.$this->moduleNameLower);
        $sourcePath = module_path($this->moduleName, 'resources/views');

        $this->publishes([$sourcePath => $viewPath], ['views', $this->moduleNameLower.'-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);

        $componentNamespace = str_replace('/', '\\', config('modules.namespace').'\\'.$this->moduleName.'\\'.ltrim(config('modules.paths.generator.component-class.path'), config('modules.paths.app_folder', '')));
        Blade::componentNamespace($componentNamespace, $this->moduleNameLower);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<string>
     */
    public function provides(): Collection
    {
        return collect([
            AuthServiceProvider::class,
            FortifyServiceProvider::class,
            WebsiteServiceProvider::class,
            AdminServiceProvider::class,
            UserServiceProvider::class,
        ]);
    }

    /**
     * @return array<string>
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (config('view.paths') as $path) {
            if (is_dir($path.'/modules/'.$this->moduleNameLower)) {
                $paths[] = $path.'/modules/'.$this->moduleNameLower;
            }
        }

        return $paths;
    }
    protected function registerTestingMacros(): void
    {
        if (class_exists(TestResponse::class)){
                     TestResponse::mixin(new TestResponseModularMacros());
         return;
        }
    }
    public function getMiddlewareGroups():Collection
    {
        return collect([
            'auth:session'=>[
                config('main.auth')
            ],
            'adminApp'=>[
                HandleAdminInertiaRequests::class
            ],
        ]);
    }
}
