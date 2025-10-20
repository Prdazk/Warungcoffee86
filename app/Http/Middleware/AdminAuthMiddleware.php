<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah admin sudah login
        if (!Auth::guard('admin')->check()) {
            // Redirect ke halaman login admin
            return redirect()->route('admin.login.form');
        }

        return $next($request);
    }
}
