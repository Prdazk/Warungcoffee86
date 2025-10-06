<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // cek apakah admin sudah login
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login.form'); // arahkan ke halaman login
        }

        return $next($request);
    }
}
