<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\Customer;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Hiển thị trang đăng ký.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view("register.index");
    }

    /**
     * Xử lý đăng ký người dùng mới.
     *
     * @param  \App\Http\Requests\RegisterRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(RegisterRequest $request)
    {
        // Tạo người dùng mới
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer', // Đặt vai trò là customer
        ]);
        $customer = Customer::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        // Đăng nhập người dùng ngay sau khi đăng ký
        Auth::login($user);
        // Lưu tên người dùng vào session
        session(['user_name' => $user->name]);

        // Chuyển hướng dựa trên vai trò
        if ($user->role === 'customer') {
            return redirect('/booking')->with('success', 'Đăng ký thành công.'); // Chuyển hướng đến trang booking
        }

        return redirect()->route('admin.index')->with('success', 'Đăng ký thành công.'); // Chuyển hướng đến trang admin (nếu có)
    }
}