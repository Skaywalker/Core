<?php

namespace Modules\Main\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Session\Middleware\AuthenticateSession as BaseAuthenticateSession;

class AuthenticateSession extends BaseAuthenticateSession
{
    /**
     * Get the guard instance that should be used by the middleware.
     *
     * @return Factory|Guard
     */
    protected function guard(): Guard|Factory
    {
        return app(StatefulGuard::class);
    }
}
