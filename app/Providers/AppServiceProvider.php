<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // alias middleware
        Route::aliasMiddleware('checkRole', \App\Http\Middleware\CheckRole::class);
        Route::aliasMiddleware('admin.auth', \App\Http\Middleware\AdminAuthMiddleware::class);
    }
}