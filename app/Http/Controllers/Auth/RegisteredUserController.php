<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController
{
    /**
     * Show the customer registration form.
     */
    public function create(Request $request): View|RedirectResponse
    {
        if ($request->user()) {
            return $request->user()->role === 'admin'
                ? redirect()->route('admin.dashboard')
                : redirect()->route('client.home');
        }

        return view('auth.login', [
            'authMode' => 'register',
        ]);
    }

    /**
     * Handle an incoming customer registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('register', [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'address_line' => ['required', 'string', 'max:1000'],
            'province_id' => ['required', 'integer'],
            'province_name' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'integer'],
            'district_name' => ['required', 'string', 'max:255'],
            'ward_code' => ['required', 'string', 'max:32'],
            'ward_name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.max' => 'Số điện thoại quá dài.',
            'address_line.required' => 'Vui lòng nhập địa chỉ chi tiết.',
            'province_id.required' => 'Vui lòng chọn tỉnh / thành phố.',
            'district_id.required' => 'Vui lòng chọn quận / huyện.',
            'ward_code.required' => 'Vui lòng chọn phường / xã.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.confirmed' => 'Xác nhận mật khẩu chưa khớp.',
        ]);

        $user = User::query()->create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $this->formatAddress($validated),
            'address_line' => $validated['address_line'],
            'province_id' => (int) $validated['province_id'],
            'province_name' => $validated['province_name'],
            'district_id' => (int) $validated['district_id'],
            'district_name' => $validated['district_name'],
            'ward_code' => $validated['ward_code'],
            'ward_name' => $validated['ward_name'],
            'password' => $validated['password'],
            'role' => 'customer',
        ]);

        Cart::query()->firstOrCreate([
            'user_id' => $user->id,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('client.home'));
    }

    /**
     * Build the full shipping address text.
     */
    protected function formatAddress(array $validated): string
    {
        return implode(', ', array_filter([
            $validated['address_line'] ?? null,
            $validated['ward_name'] ?? null,
            $validated['district_name'] ?? null,
            $validated['province_name'] ?? null,
        ]));
    }
}
