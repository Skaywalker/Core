<?php

namespace Modules\Main\Class;

use Modules\Admin\Class\AdminRouter;
use Stringable;
use Tighten\Ziggy\Ziggy;

class CoreRouterMergeScript implements Stringable
{
    public function __construct(
        protected WebsiteRouter|AdminRouter $ziggy,
        protected string $nonce = '',
    ) {}

    public function __toString(): string
    {
        $routes = json_encode($this->ziggy->toArray()['routes']);

        return <<<HTML
        <script type="text/javascript"{$this->nonce}>Object.assign(Ziggy.routes,{$routes});</script>
        HTML;
    }
}
