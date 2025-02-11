<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'IsActive' => \App\Http\Middleware\IsActive::class,
            'IsInjection' => \App\Http\Middleware\IsInjection::class,
            'IsLine1' => \App\Http\Middleware\IsLine1::class,
            'IsLine2' => \App\Http\Middleware\IsLine2::class,
            'IsPm' => \App\Http\Middleware\IsPm::class,
            'IsAdmin' => \App\Http\Middleware\IsAdmin::class,
            'IsWarehouse' => \App\Http\Middleware\IsWarehouse::class,
            'IsManager' => \App\Http\Middleware\IsManager::class,
            'IsProduction' => \App\Http\Middleware\IsProduction::class,
            'IsQc' => \App\Http\Middleware\IsQc::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            // 'http://localhost:82/pbb-system/public/pbb_stockcode' // <-- exclude this route
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
