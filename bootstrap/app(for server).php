<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'ensure.inventory' => \App\Http\Middleware\EnsureUserHasInventory::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //

    })
    ->create();

$app->usePublicPath('/home/u406345208/domains/lime-yak-430003.hostingersite.com/public_html');

return $app;
