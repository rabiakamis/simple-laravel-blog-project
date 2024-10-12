<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\StartCustomSession;
use Illuminate\Session\Middleware\StartSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "isAdmin" => \App\Http\Middleware\isAdmin::class,
            "isLogin" => \App\Http\Middleware\isLogin::class,
        ]);
        // Buraya başka middleware'ler ekleyebilirsiniz.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
