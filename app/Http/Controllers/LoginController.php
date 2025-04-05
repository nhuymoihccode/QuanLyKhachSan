<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Hiển thị trang đăng nhập.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (Auth::check()) {
            return $this->redirectUser(); // Gọi phương thức redirectUser để xử lý điều hướng
        }

        return view("login.index"); // Nếu chưa đăng nhập, hiển thị form đăng nhập
    }

    /**
     * Xử lý đăng nhập.
     *
     * @param  \App\Http\Requests\LoginRequest  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        // Xác thực thông tin đăng nhập
        $credentials = $request->validated();

        // Kiểm tra thông tin đăng nhập
        if (Auth::attempt($credentials)) {
            // Tạo token cho người dùng
            $token = Auth::user()->createToken('YourAppName')->plainTextToken;

            // Chuyển hướng đến dashboard
            return redirect()->route('dashboard.index'); // Chỉnh sửa ở đây
        }

        // Nếu thông tin đăng nhập không chính xác
        return redirect()->route('login.index')->with('error', 'Email hoặc Mật khẩu không chính xác');
    }

    /**
     * Xử lý đăng xuất.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if ($request->user()) {
            // Xóa tất cả token của người dùng
            $request->user()->tokens()->delete(); 
        }
        
        Auth::logout(); // Đăng xuất người dùng
        $request->session()->invalidate(); // Xóa session
        $request->session()->regenerateToken(); // Tạo lại token CSRF
        
        return redirect()->route('login.index');
    }

    /**
     * Phương thức điều hướng người dùng dựa trên vai trò.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    private function redirectUser()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('dashboard.index')->with('success', 'Đăng nhập thành công với tư cách admin');
        }

        return redirect()->route('booking.index')->with('success', 'Đăng nhập thành công với tư cách customer');
    }
}