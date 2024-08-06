<?php

namespace Modules\Main\Class;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Admin\Class\AdminRouter;

class BcmsRouterTypes
{
    public function __construct(
        protected AdminRouter|WebsiteRouter $ziggy,
    ) {}

    public function __toString(): string
    {
        $module=get_class($this->ziggy)===AdminRouter::class?'adminRouter-js':'websiteRouter-js';
        $routes = collect($this->ziggy->toArray()['routes'])->map(function ($route) {
            return collect($route['parameters'] ?? [])->map(function ($param) use ($route) {
                return Arr::has($route, "bindings.{$param}")
                    ? ['name' => $param, 'required' => ! Str::contains($route['uri'], "{$param}?"), 'binding' => $route['bindings'][$param]]
                    : ['name' => $param, 'required' => ! Str::contains($route['uri'], "{$param}?")];
            });
        });

        return <<<JAVASCRIPT
        /* This file is generated by Bcms */
        declare module '{$module}' {
          interface RouteList {$routes->toJson(JSON_PRETTY_PRINT)}
        }
        export {};

        JAVASCRIPT;
    }
}