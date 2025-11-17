<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::guard('admin')->user();

        if (!$user) {
            return redirect()->route('admin.login.form');
        }
        $role = strtolower($user->role);

        if ($role === 'superadmin') {
            return $next($request);
        }

        if (in_array($role, $roles)) {
            return $next($request);
        }

        return redirect()->route('admin.beranda')->with('error', 'Akses ditolak!');
    }
}