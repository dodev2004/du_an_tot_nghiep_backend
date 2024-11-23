<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetGuard
{
    public function handle($request, Closure $next)
    {
        // Kiểm tra nếu yêu cầu là API
        if ($request->is('api/*')) {
            Auth::shouldUse('api');
        } else {
            Auth::shouldUse('web');
        }

        return $next($request);
    }
}
