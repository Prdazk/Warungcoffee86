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

            View::composer('admin.*', function ($view) {
            // Ambil semua reservasi yang status-nya Dipesan (artinya baru masuk)
            $reservasiBaru = Reservasi::where('status', 'Dipesan')->latest()->get();
            $jumlahBaru = $reservasiBaru->count();

            $view->with(compact('reservasiBaru', 'jumlahBaru'));
        });

    }
}
