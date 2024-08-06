<?php

namespace Modules\Main\Class;

use Modules\Admin\Class\AdminRouter;

class BcmsRouterFile
{
    public function __construct(
        protected AdminRouter|WebsiteRouter $ziggy,
    ) {}

    public function __toString(): string
    {
        $module=get_class($this->ziggy)===AdminRouter::class?'AdminRouter':'WebsiteRouter';
        return <<<JAVASCRIPT
        const {$module} = {$this->ziggy->toJson()};
        if (typeof window !== 'undefined' && typeof window.{$module} !== 'undefined') {
          Object.assign({$module}.routes, window.{$module}.routes);
        }
        export { {$module} };
        JAVASCRIPT;
    }
}