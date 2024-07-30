<?php

namespace Modules\Main\Class;

use Modules\Admin\Class\AdminRouter;
use Tighten\Ziggy\Output\MergeScript;
use Tighten\Ziggy\Output\Script;

class BladeRouteGenerator
{
    public static $generated;

    public function generate( AdminRouter|WebsiteRouter $class , string $nonce = null): string
    {
        $ziggy = $class;

        $nonce = $nonce ? " nonce=\"{$nonce}\"" : '';

        if (static::$generated) {
            return (string) $this->generateMergeJavascript($ziggy, $nonce);
        }

        static::$generated = true;

        $output = config('ziggy.output.script', Script::class);

        $routeFunction = config('ziggy.skip-route-function') ? '' : module_path('Main','/app/Class/dist/routes.umd.js');

        return (string) new $output($ziggy, $routeFunction, $nonce);
    }

    private function generateMergeJavascript(AdminRouter|WebsiteRouter $ziggy, string $nonce)
    {
        $output = config('ziggy.output.merge_script', CoreRouterMergeScript::class);

        return new $output($ziggy, $nonce);
    }
}
