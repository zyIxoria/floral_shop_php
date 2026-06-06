<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.']);
        }

        // Kiểm tra tài khoản có bị vô hiệu hóa/block không
        if (Auth::user()->status === 'blocked') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Tài khoản của bạn đã bị vô hiệu hóa. Vui lòng liên hệ với ban quản trị.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
