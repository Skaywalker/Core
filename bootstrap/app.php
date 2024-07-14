<?php


use  Modules\Admin\Middleware\HandleAdminRoutesInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
       $middleware->append([HandleAdminRoutesInertiaRequests::class]);
        $middleware->append([\Modules\Main\Http\Middleware\Localization::class]);
        $middleware->web( [\App\Http\Middleware\HandleInertiaRequests::class,
            ]);


    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
