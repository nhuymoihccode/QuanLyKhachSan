<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthenticateMiddware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã được xác thực hay chưa
        if (!Auth::check()) {
            return redirect()->route('login.index')->with('error', 'Bạn phải đăng nhập để sử dụng chức năng này');
        }

        // Lưu tên người dùng vào session
        $request->session()->put('user_name', Auth::user()->name);

        return $next($request);
    }
}