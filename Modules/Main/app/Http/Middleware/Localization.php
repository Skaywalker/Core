<?php

namespace Modules\Main\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $avail=config('app.available_languages');
        if (!session('lang') && in_array(session('lang'), $avail)) {
            app()->setLocale(config('app.locale'));
            session()->put('lang',config('app.locale'));
        } else {
            Log::channel('dev')->info('Is Valid langrige', ['lang' => session('lang'), 'available' => $avail, 'default' => config('app.locale'),'set'=>app()->getLocale()]);
        }
        return $next($request);
    }
}
