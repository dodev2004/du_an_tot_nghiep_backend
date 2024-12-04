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
            return redirect()->route('permission.denied')->with('error', 'Bạn không có quyền truy cập vào trang này'); // Chuyển hướng đến trang lỗi với thông báo
        }

        return $next($request); // Tiếp tục yêu cầu nếu có quyền
    }
}
