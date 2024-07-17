<?php

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HandleAdminRoutesInertiaRequests
{
    public function handle(Request $request, Closure $next)
    {
        // Ellenőrzi, hogy az útvonal admin-e
        if ($request->is('admin\*')||$request->is('admin')) {
            $handAdminleInertiaRequests = new \Modules\Admin\Http\Middleware\HandAdminleInertiaRequests;
            return $handAdminleInertiaRequests->handle($request, $next);
            // Itt alkalmazza a HandleInertiaRequests logikát
            // Például közvetlenül meghívhatja a HandleInertiaRequests köztes réteget,
            // vagy implementálhatja annak logikáját ebben a blokkban
        }

        return $next($request);
    }
}