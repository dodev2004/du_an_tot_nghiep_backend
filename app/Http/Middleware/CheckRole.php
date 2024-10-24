<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {

        if (!Auth::user()->hasRole($role)) {

            abort(403, 'Bạn không có quyền truy cập vào trang này'); // Trả về lỗi 403 nếu không có quyền
        }

        return $next($request);
    }
}
