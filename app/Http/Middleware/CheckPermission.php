<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        // Kiểm tra xem người dùng có đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect('/login'); // Điều hướng về trang đăng nhập nếu chưa đăng nhập
        }

        $user = Auth::user();

        // Kiểm tra quyền của người dùng
        if (!$user->hasPermission($permission)) {
            abort(403, 'Bạn không có quyền truy cập vào trang này'); // Trả về lỗi 403 nếu không có quyền
        }

        return $next($request); // Tiếp tục yêu cầu nếu có quyền
    }
}
