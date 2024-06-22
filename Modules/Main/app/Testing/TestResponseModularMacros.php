<?php

namespace Modules\Main\Testing;

use Closure;

class TestResponseModularMacros
{
    public function assertInertiaModular(): Closure
    {
        return function (Closure $callback = null) {
            $assert = AssertableInertiaModular::fromTestResponse($this);

            if (is_null($callback)) {
                return $this;
            }

            $callback($assert);

            return $this;
        };
    }

    public function inertiaPage(): Closure
    {
        return function () {
            return AssertableInertiaModular::fromTestResponse($this)->toArray();
        };
    }
}
