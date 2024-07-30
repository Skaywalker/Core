<?php

namespace Modules\Main\Class;


use Modules\Admin\Class\AdminRouter;

class CoreRouterScript
{
    public function __construct(
        protected AdminRouter|WebsiteRouter $ziggy,
        protected string $function,
        protected string $nonce = '',
    ) {}

    public function __toString(): string
    {
        return <<<HTML
        <script type="text/javascript"{$this->nonce}>const Ziggy={$this->ziggy->toJson()};{$this->function}</script>
        HTML;
    }
}