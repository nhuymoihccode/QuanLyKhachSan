<?php 
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.passwords.verify');
    }

    public function verifyCode(Request $request)
    {
        $request->validate(['email' => 'required|email', 'code' => 'required']);

        $reset = PasswordReset::where('email', $request->email)->where('code', $request->code)->first();

        if (!$reset || $reset->created_at->addMinutes(2) < now()) {
            return back()->withErrors(['code' => 'Mã xác nhận không hợp lệ hoặc đã hết hạn.']);
        }

        return redirect()->route('forgot_pass.reset.form', ['email' => $request->email]);
    }

    public function showResetForm(Request $request)
    {
        return view('auth.passwords.reset')->with(['email' => $request->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        PasswordReset::where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Mật khẩu đã được đặt lại!');
    }
}