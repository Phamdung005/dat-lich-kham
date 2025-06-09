<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsPatient
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'patient') {
            return $next($request);
        }
        abort(403, 'Bạn không có quyền truy cập.');
    }
}
