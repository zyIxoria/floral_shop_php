<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'email.exists' => 'Email này không tồn tại trong hệ thống.',
        ]);

        $email = $request->email;
        // Generate a 6-digit random code
        $code = (string) mt_rand(100000, 999999);

        // Store reset details in session, valid for 10 minutes
        session([
            'reset_email' => $email,
            'reset_code' => $code,
            'reset_code_expires_at' => now()->addMinutes(10),
        ]);

        return redirect()->route('password.verify.form')
            ->with('success', "Mã xác nhận đã được gửi thành công. Vì đây là phiên bản thử nghiệm (Demo), vui lòng dùng mã xác nhận sau: {$code}");
    }

    public function showVerifyCodeForm(): View|RedirectResponse
    {
        if (!session()->has('reset_email') || !session()->has('reset_code')) {
            return redirect()->route('password.request')
                ->with('error', 'Vui lòng nhập email trước.');
        }

        // Check if expired
        $expiresAt = session('reset_code_expires_at');
        if (now()->greaterThan($expiresAt)) {
            session()->forget(['reset_email', 'reset_code', 'reset_code_expires_at']);
            return redirect()->route('password.request')
                ->with('error', 'Mã xác nhận đã hết hạn. Vui lòng lấy mã mới.');
        }

        return view('auth.verify-code');
    }

    public function verifyCode(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Vui lòng nhập mã xác nhận.',
            'code.size' => 'Mã xác nhận phải gồm đúng 6 chữ số.',
        ]);

        if (!session()->has('reset_email') || !session()->has('reset_code')) {
            return redirect()->route('password.request')
                ->with('error', 'Phiên làm việc đã hết hạn. Vui lòng thực hiện lại.');
        }

        $expiresAt = session('reset_code_expires_at');
        if (now()->greaterThan($expiresAt)) {
            session()->forget(['reset_email', 'reset_code', 'reset_code_expires_at']);
            return redirect()->route('password.request')
                ->with('error', 'Mã xác nhận đã hết hạn. Vui lòng lấy mã mới.');
        }

        if ($request->code !== session('reset_code')) {
            return back()->withErrors(['code' => 'Mã xác nhận không chính xác.']);
        }

        // OTP verified successfully
        session(['reset_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    public function showResetForm(): View|RedirectResponse
    {
        if (!session('reset_verified')) {
            return redirect()->route('password.request')
                ->with('error', 'Vui lòng xác minh mã trước.');
        }

        return view('auth.reset-password');
    }

    public function reset(Request $request): RedirectResponse
    {
        if (!session('reset_verified')) {
            return redirect()->route('password.request')
                ->with('error', 'Yêu cầu không hợp lệ. Vui lòng thực hiện lại từ đầu.');
        }

        $request->validate([
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>_+-]/',
            ],
        ], [
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'password.min' => 'Mật khẩu phải dài ít nhất 8 ký tự.',
            'password.regex' => 'Mật khẩu phải bao gồm cả chữ hoa, chữ thường, số và ký tự đặc biệt.',
        ]);

        $email = session('reset_email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')
                ->with('error', 'Không tìm thấy người dùng phù hợp.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clean up session
        session()->forget(['reset_email', 'reset_code', 'reset_code_expires_at', 'reset_verified']);

        return redirect()->route('login')
            ->with('success', 'Thay đổi mật khẩu thành công! Vui lòng đăng nhập bằng mật khẩu mới.');
    }
}
