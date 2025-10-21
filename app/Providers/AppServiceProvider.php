<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Models\Reservasi;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Alias middleware tetap ada
        Route::aliasMiddleware('checkRole', \App\Http\Middleware\CheckRole::class);
        Route::aliasMiddleware('admin.auth', \App\Http\Middleware\AdminAuthMiddleware::class);

        // View composer untuk semua view admin.*
        View::composer('admin.*', function ($view) {
            $reservasiBaru = Reservasi::where('status', 'baru')->latest()->get();
            $jumlahBaru = $reservasiBaru->count();
            $view->with(compact('reservasiBaru', 'jumlahBaru'));
        });
    }
}
