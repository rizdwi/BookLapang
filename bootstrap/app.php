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
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->trustProxies(at: '*');

        $middleware->append(\App\Http\Middleware\SecurityHeadersMiddleware::class);

        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Di lingkungan Vercel Serverless (Read-Only Root Filesystem), alihkan storage ke /tmp
if (isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL']) || getenv('VERCEL')) {
    $app->useStoragePath('/tmp/storage');
    $app->booted(function ($app) {
        config([
            'app.name' => 'BookLapang',
            'app.url' => 'https://book-lapang.vercel.app',
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => '/tmp/database.sqlite',
            'session.driver' => 'cookie',
            'session.lifetime' => 120,
            'cache.default' => 'array',
        ]);
    });
}

return $app;
