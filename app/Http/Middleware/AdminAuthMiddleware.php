<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Jika admin belum login
        if (!Auth::guard('admin')->check()) {
            // Kalau request AJAX, kirimkan error JSON
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // Kalau bukan AJAX, arahkan ke halaman login admin
            return redirect()->route('admin.login.form')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika sudah login, lanjutkan request
        return $next($request);
    }
}