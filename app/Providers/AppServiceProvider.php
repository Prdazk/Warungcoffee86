<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\Reservasi;
use App\Models\AdminData;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Route::aliasMiddleware('checkRole', \App\Http\Middleware\CheckRole::class);
        Route::aliasMiddleware('admin.auth', \App\Http\Middleware\AdminAuthMiddleware::class);

        View::composer('admin.*', function ($view) {
            $reservasiBaru = Reservasi::where('status', 'Dipesan')->latest()->get();
            $jumlahBaru = $reservasiBaru->count();
            $view->with(compact('reservasiBaru', 'jumlahBaru'));
        });

        Event::listen(Login::class, function ($event) {
            $user = $event->user;
            if ($user instanceof AdminData) {

                $user->update(['status' => 1]);

                AdminData::where('id', '!=', $user->id)->update(['status' => 0]);
            }
        });

        Event::listen(Logout::class, function ($event) {
            $user = $event->user;
            if ($user instanceof AdminData) {

                $user->update(['status' => 0]);
            }
        });
    }
}