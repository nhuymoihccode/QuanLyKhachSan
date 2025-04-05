<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Thêm phương thức này
    public function index()
    {
        return view("forgot_pass.index");
    }

    // Đổi tên phương thức này
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Kiểm tra xem email tồn tại trong bảng users
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Email không tồn tại.']);
        }

        // Tạo mã xác nhận 6 số ngẫu nhiên
        $code = rand(100000, 999999);

        // Lưu mã xác nhận vào bảng password_resets với thời gian tạo
        PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['code' => $code, 'created_at' => now()]
        );

        // Gửi email chứa mã xác nhận
        Mail::send('forgot_pass.reset_email', ['code' => $code], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Đặt lại mật khẩu');
        });

        return redirect()->route('forgot_pass.verify')->with('status', 'Mã xác nhận đã được gửi đến email của bạn.');
    }
}