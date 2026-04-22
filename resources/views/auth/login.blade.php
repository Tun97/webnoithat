@php
    $activePanel = old('_auth_mode', $authMode ?? 'login');

    if ($errors->register->any()) {
        $activePanel = 'register';
    }

    if ($errors->login->any()) {
        $activePanel = 'login';
    }
@endphp
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tài khoản khách hàng</title>
    @vite(['resources/css/client/auth.css', 'resources/js/client/auth.js'])
</head>
<body class="auth-page">
    <div class="auth-scene">
        <a href="{{ route('client.home') }}" class="auth-back">Về trang chủ</a>

        <section
            class="auth-shell @if ($activePanel === 'register') is-register @endif"
            data-auth-shell
            data-auth-panel="{{ $activePanel }}"
        >
            <div class="auth-card">
                <div class="auth-form auth-form--register">
                    <div class="auth-form__inner">
                        <p class="auth-form__eyebrow">Đăng ký</p>
                        <h1>Tạo tài khoản mới</h1>
                        <p class="auth-form__summary">Điền đủ thông tin khách hàng và chọn đúng Tỉnh, Quận, Phường để lần thanh toán sau nhanh hơn.</p>

                        @if ($errors->register->any())
                            <div class="auth-alert auth-alert--error">
                                @foreach ($errors->register->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form action="{{ route('register.store') }}" method="POST" class="auth-fields">
                            @csrf
                            <input type="hidden" name="_auth_mode" value="register">

                            <label class="auth-field">
                                <span>Họ và tên</span>
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Nguyễn Văn A" required>
                            </label>

                            <label class="auth-field">
                                <span>Email</span>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="ban@email.com" required>
                            </label>

                            <label class="auth-field">
                                <span>Số điện thoại</span>
                                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="0901 234 567" required>
                            </label>

                            @include('client.partials.address-selector', [
                                'provinceId' => null,
                                'provinceName' => null,
                                'districtId' => null,
                                'districtName' => null,
                                'wardCode' => null,
                                'wardName' => null,
                            ])

                            <label class="auth-field">
                                <span>Địa chỉ chi tiết</span>
                                <textarea name="address_line" rows="3" placeholder="Số nhà, tên đường, thôn/tổ dân phố..." required>{{ old('address_line') }}</textarea>
                            </label>

                            <label class="auth-field">
                                <span>Mật khẩu</span>
                                <input type="password" name="password" placeholder="Tạo mật khẩu" required>
                            </label>

                            <label class="auth-field">
                                <span>Xác nhận mật khẩu</span>
                                <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
                            </label>

                            <button type="submit" class="auth-submit">Đăng ký</button>
                        </form>
                    </div>
                </div>

                <div class="auth-form auth-form--login">
                    <div class="auth-form__inner">
                        <p class="auth-form__eyebrow">Đăng nhập</p>
                        <h2>Chào mừng quay lại</h2>
                        <p class="auth-form__summary">Đăng nhập để mở giỏ hàng của bạn và dùng lại địa chỉ giao hàng đã lưu.</p>

                        @if (session('status'))
                            <div class="auth-alert auth-alert--success">{{ session('status') }}</div>
                        @endif

                        @if ($errors->login->any())
                            <div class="auth-alert auth-alert--error">
                                @foreach ($errors->login->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form action="{{ route('login.store') }}" method="POST" class="auth-fields">
                            @csrf
                            <input type="hidden" name="_auth_mode" value="login">

                            <label class="auth-field">
                                <span>Email</span>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="ban@email.com" required autofocus>
                            </label>

                            <label class="auth-field">
                                <span>Mật khẩu</span>
                                <input type="password" name="password" placeholder="Nhập mật khẩu" required>
                            </label>

                            <label class="auth-check">
                                <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                                <span>Ghi nhớ đăng nhập</span>
                            </label>

                            <button type="submit" class="auth-submit">Đăng nhập</button>
                        </form>
                    </div>
                </div>

                <div class="auth-overlay">
                    <div class="auth-overlay__content auth-overlay__content--left">
                        <p class="auth-overlay__eyebrow">Hello, Welcome</p>
                        <h2>Chưa có tài khoản?</h2>
                        <p>Tạo tài khoản để lưu tên, số điện thoại và bộ địa chỉ GHN cho những lần mua sau.</p>
                        <button type="button" class="auth-toggle" data-auth-target="register">Register</button>
                    </div>

                    <div class="auth-overlay__content auth-overlay__content--right">
                        <p class="auth-overlay__eyebrow">Welcome Back!</p>
                        <h2>Đã có tài khoản?</h2>
                        <p>Đăng nhập để mở giỏ hàng của bạn và tiếp tục các sản phẩm đang chọn.</p>
                        <button type="button" class="auth-toggle" data-auth-target="login">Login</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
</body>
</html>
