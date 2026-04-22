<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController
{
    /**
     * Show the login form.
     */
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return $request->user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('client.home');
        }

        return view('auth.login', [
            'authMode' => 'login',
        ]);
    }

    /**
     * Handle an incoming authentication request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $intendedUrl = $request->session()->get('url.intended');

        $credentials = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ])->validateWithBag('login');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $exception = ValidationException::withMessages([
                'email' => 'Thông tin đăng nhập không chính xác.',
            ]);

            $exception->errorBag = 'login';

            throw $exception;
        }

        $request->session()->regenerate();

        $user = $request->user();
        $intendedPath = is_string($intendedUrl) ? parse_url($intendedUrl, PHP_URL_PATH) : null;

        if ($intendedPath && str_starts_with($intendedPath, '/admin') && $user->role !== 'admin') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $exception = ValidationException::withMessages([
                'email' => 'Tài khoản này không có quyền truy cập trang quản trị.',
            ]);

            $exception->errorBag = 'login';

            throw $exception;
        }

        return $user->role === 'admin'
            ? redirect()->intended(route('admin.dashboard'))
            : redirect()->intended(route('client.home'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('status', 'Đăng xuất thành công.');
    }
}
