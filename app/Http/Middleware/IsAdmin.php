<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // hanya izinkan user login yang is_admin = true
        if (! $request->user() || ! $request->user()->is_admin) {
            abort(403, 'Akses ditolak. Hanya admin yang bisa mengakses.');
        }

        return $next($request);
    }
}
