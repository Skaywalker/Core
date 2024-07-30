<?php

namespace Modules\Admin\Class;

use Modules\Main\Class\CoreRouterMergeScript;
use Modules\Main\Class\CoreRouterScript;


class AdminBladeRouteGenerator
{
    public static $generated;

    public function generate($group = null, string $nonce = null): string
    {
        $ziggy = new AdminRouter($group);

        $nonce = $nonce ? " nonce=\"{$nonce}\"" : '';

        if (static::$generated) {
            return (string) $this->generateMergeJavascript($ziggy, $nonce);
        }

        static::$generated = true;

        $output = config('ziggy.output.script', CoreRouterScript::class);

        $routeFunction = config('ziggy.skip-route-function') ? '' :file_get_contents( module_path('Main','app/Class/dist/route.umd.js'));

        return (string) new $output($ziggy, $routeFunction, $nonce);
    }

    private function generateMergeJavascript(AdminRouter $ziggy, string $nonce)
    {
        $output = config('ziggy.output.merge_script', CoreRouterMergeScript::class);

        return new $output($ziggy, $nonce);
    }
}
