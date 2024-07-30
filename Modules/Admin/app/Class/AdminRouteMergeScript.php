<?php

namespace Modules\Admin\Class;

use Stringable;
use Tighten\Ziggy\Ziggy;

class AdminRouteMergeScript implements Stringable
{



    public function __construct(
        protected Ziggy  $ziggy,
        protected string $nonce = '',
    )
    {
    }

    public function __toString(): string
    {
        $routes = json_encode($this->ziggy->toArray()['routes']);

        return <<<HTML
        <script type="text/javascript"{$this->nonce}>Object.assign(Ziggy.routes,{$routes});</script>
        HTML;
    }
}

