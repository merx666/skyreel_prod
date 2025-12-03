<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\SecureHeaders;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        // Register security headers middleware for web and api groups
        $router->pushMiddlewareToGroup('web', SecureHeaders::class);
        $router->pushMiddlewareToGroup('api', SecureHeaders::class);
    }
}
