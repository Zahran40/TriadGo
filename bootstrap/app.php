<?php

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
        // Configure CSRF exclusions
        $middleware->validateCsrfTokens(except: [
            'midtrans/*',
        ]);
        
        // Register middleware alias
        $middleware->alias([
            'admin.access' => \App\Http\Middleware\AdminAccess::class,
            'role.protect' => \App\Http\Middleware\RoleProtection::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();