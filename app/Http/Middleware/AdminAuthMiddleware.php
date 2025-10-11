<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Cek guard admin
        if (!Auth::guard('admin')->check()) {
            // tampilkan pesan jika belum login
            return response('<h2>Anda harus login terlebih dahulu!</h2>', 403);
        }

        return $next($request);
    }
}
