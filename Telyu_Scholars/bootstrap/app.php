<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 1. Alias Middleware
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // 2. Disable CSRF untuk API/Testing Route tertentu (CARA LARAVEL 11)
        $middleware->validateCsrfTokens(except: [
            'provider/scholarships',      // Untuk store (POST)
            'provider/scholarships/*',    // Untuk update/delete (PUT/DELETE)
        ]);

        // 3. Trust Proxies untuk AWS/Vercel Reverse Proxy
        $middleware->trustProxies(at: '*', headers: Request::HEADER_X_FORWARDED_AWS_ELB);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
    