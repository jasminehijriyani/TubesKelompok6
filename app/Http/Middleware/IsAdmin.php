<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user sudah login dan punya role admin
        if (auth()->check() && auth()->user()->is_admin) {
            return $next($request);
        }

        // Kalau bukan admin, abort 403
        return abort(403, 'Unauthorized.');
    }
}
