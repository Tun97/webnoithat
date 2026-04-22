<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trang chủ')</title>
    @vite(['resources/css/client/app.css', 'resources/js/client/app.js'])
</head>
<body class="client-page client-page--@yield('client_page', 'home')">
    <div class="client-shell">
        <header class="site-header">
            <div class="container">
                <div class="header-top">
                    <div class="service-list">
                        <div class="service-item">
                            <span class="service-icon">&#9742;</span>
                            <div>
                                <div>Hotline</div>
                                <strong>0968 498 556</strong>
                            </div>
                        </div>
                        <div class="service-item">
                            <span class="service-icon">&#128666;</span>
                            <div>
                                <div>Giao hàng</div>
                                <strong>Toàn quốc</strong>
                            </div>
                        </div>
                        <div class="service-item">
                            <span class="service-icon">&#8363;</span>
                            <div>
                                <div>Thanh toán</div>
                                <strong>Tại nhà</strong>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('client.home') }}" class="brand">
                        @if (file_exists(public_path('images/logo.png')))
                            <img src="{{ asset('images/logo.png') }}" alt="TAT Interior" class="brand-logo">
                        @else
                            <span class="brand-mark">H</span>
                            <strong>TAT</strong>
                            <span>Nội thất cao cấp</span>
                        @endif
                    </a>

                    <div class="search-wrap">
                        <form method="GET" action="{{ route('client.products.index') }}" class="search-bar">
                            <select name="category" aria-label="Danh mục tìm kiếm">
                                <option value="">Tất cả</option>
                                @foreach ($catalogCategories ?? [] as $catalogCategory)
                                    <option value="{{ $catalogCategory->slug }}" @selected(request('category') === $catalogCategory->slug)>
                                        {{ $catalogCategory->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Bạn tìm kiếm sản phẩm nào?"
                            >
                            <button type="submit">Tìm kiếm</button>
                        </form>

                        <nav class="header-nav">
                            <a href="{{ route('client.home') }}" @class(['is-active' => request()->routeIs('client.home')])>Trang chủ</a>
                            <a href="{{ route('client.products.index') }}" @class(['is-active' => request()->routeIs('client.products.*')])>Sản phẩm</a>
                            <a href="{{ route('client.about') }}" @class(['is-active' => request()->routeIs('client.about')])>Giới thiệu</a>
                            <a href="{{ route('client.contact') }}" @class(['is-active' => request()->routeIs('client.contact')])>Liên hệ</a>
                            <a href="{{ route('client.cart.index') }}" @class(['is-active' => request()->routeIs('client.cart.*')])>Giỏ hàng</a>
                            @auth
                                <a href="{{ route('client.orders.index') }}" @class(['is-active' => request()->routeIs('client.orders.*')])>Đơn hàng</a>
                                <span class="header-auth__label">Xin chào, {{ auth()->user()->name }}</span>
                                <form action="{{ route('logout') }}" method="POST" class="header-auth__form">
                                    @csrf
                                    <button type="submit" class="header-auth__button">Đăng xuất</button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" @class(['is-active' => request()->routeIs('login', 'register')])>Đăng nhập</a>
                            @endauth
                        </nav>
                    </div>
                </div>

                <div class="hero-bar">
                    <div class="catalog-wrapper" data-catalog-wrapper>
                        <button type="button" class="catalog-trigger" data-catalog-toggle>
                            <span>&#9776;</span>
                            <span>Danh mục sản phẩm</span>
                        </button>
                        <div class="catalog-panel">
                            <ul class="catalog-list">
                                @forelse ($catalogCategories ?? [] as $catalogCategory)
                                    <li class="catalog-item">
                                        <a href="{{ route('client.products.index', ['category' => $catalogCategory->slug]) }}">
                                            <span>{{ $catalogCategory->name }}</span>
                                            <span>{{ $catalogCategory->products_count }}</span>
                                        </a>
                                    </li>
                                @empty
                                    <li class="catalog-item">
                                        <a href="{{ route('client.products.index') }}">
                                            <span>Danh mục đang được cập nhật</span>
                                            <span>&bull;</span>
                                        </a>
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="header-note">
                        <span>Thiết kế theo cảm hứng nội thất tân cổ điển</span>
                    </div>
                </div>
            </div>
        </header>

        <main>
            <div class="container">
                @yield('content')
            </div>
        </main>

        <footer class="site-footer">
            <div class="footer-cta">
                <div class="container footer-cta__inner">
                    <div class="footer-cta__copy">
                        <span class="footer-cta__icon">&#128222;</span>
                        <strong>Để lại số điện thoại để được tư vấn miễn phí!</strong>
                    </div>

                    <div class="footer-cta__action">
                        <form
                            action="{{ route('client.contact.quick') }}"
                            method="POST"
                            @class(['footer-cta__form', 'footer-cta__form--error' => $errors->footerConsultation->any()])
                        >
                            @csrf
                            <input
                                type="tel"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Nhập số điện thoại của bạn tại đây..."
                                inputmode="tel"
                                autocomplete="tel"
                                pattern="(?:0[35789](?:[\s.\-]?[0-9]){8}|\+84[35789](?:[\s.\-]?[0-9]){8})"
                                title="Nhập số di động Việt Nam, ví dụ 0977665554 hoặc +84977665554"
                                required
                            >
                            <button type="submit">Tư vấn ngay</button>
                        </form>

                        @if (session('footer_consultation_status'))
                            <div class="footer-cta__feedback footer-cta__feedback--success">
                                {{ session('footer_consultation_status') }}
                            </div>
                        @endif

                        @if ($errors->footerConsultation->any())
                            <div class="footer-cta__feedback footer-cta__feedback--error">
                                {{ $errors->footerConsultation->first('phone') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="footer-links">
                    <div class="footer-col">
                        <h3>Nội thất phòng khách</h3>
                        <ul>
                            <li><a href="#">Kệ tivi</a></li>
                            <li><a href="#">Tủ rượu</a></li>
                            <li><a href="#">Sofa tân cổ điển</a></li>
                            <li><a href="#">Bàn trà</a></li>
                            <li><a href="#">Đôn</a></li>
                        </ul>
                        <a href="#" class="footer-more">Xem thêm</a>
                    </div>

                    <div class="footer-col">
                        <h3>Nội thất phòng ăn</h3>
                        <ul>
                            <li><a href="#">Bàn ghế ăn</a></li>
                            <li><a href="#">Tủ đồ phòng ăn</a></li>
                            <li><a href="#">Đồ trang trí phòng ăn</a></li>
                        </ul>
                        <a href="#" class="footer-more">Xem thêm</a>
                    </div>

                    <div class="footer-col">
                        <h3>Nội thất phòng ngủ</h3>
                        <ul>
                            <li><a href="#">Giường</a></li>
                            <li><a href="#">Tủ quần áo</a></li>
                            <li><a href="#">Bàn trang điểm</a></li>
                            <li><a href="#">Gương</a></li>
                            <li><a href="#">Ghế đuôi giường</a></li>
                        </ul>
                        <a href="#" class="footer-more">Xem thêm</a>
                    </div>

                    <div class="footer-col">
                        <h3>Đồ trang trí tân cổ điển</h3>
                        <ul>
                            <li><a href="#">Đồng hồ</a></li>
                            <li><a href="#">Đèn tường trang trí</a></li>
                            <li><a href="#">Quạt</a></li>
                            <li><a href="#">Đèn ngủ, đèn bàn, đèn cây</a></li>
                            <li><a href="#">Đồ trang trí gốm sứ</a></li>
                        </ul>
                        <a href="#" class="footer-more">Xem thêm</a>
                    </div>

                    <div class="footer-col">
                        <h3>Nội thất hoàng gia</h3>
                        <ul>
                            <li><a href="#">Bàn cafe</a></li>
                            <li><a href="#">Hàng order cao cấp</a></li>
                            <li><a href="#">Thiết kế theo yêu cầu</a></li>
                        </ul>
                        <a href="#" class="footer-more">Xem thêm</a>
                    </div>

                    <div class="footer-col footer-col--stacked">
                        <div class="footer-mini">
                            <h3>Tranh sơn dầu Châu Âu</h3>
                            <a href="#" class="footer-more">Xem thêm</a>
                        </div>
                        <div class="footer-mini">
                            <h3>Máy phát nhạc tân cổ điển</h3>
                            <a href="#" class="footer-more">Xem thêm</a>
                        </div>
                        <div class="footer-mini">
                            <h3>Đồ cổ Châu Âu</h3>
                            <a href="#" class="footer-more">Xem thêm</a>
                        </div>
                        <!-- <div class="footer-mini">
                            <h3>Nội thất phòng làm việc</h3>
                            <a href="#" class="footer-more">Xem thêm</a>
                        </div> -->
                        <!-- <div class="footer-mini">
                            <h3>Pha lê cao cấp</h3>
                            <a href="#" class="footer-more">Xem thêm</a>
                        </div>
                        <div class="footer-mini">
                            <h3>Tượng, tiểu cảnh sân vườn</h3>
                            <a href="#" class="footer-more">Xem thêm</a>
                        </div> -->
                    </div>
                </div>

                <div class="footer-bottom">
                    <span>CÔNG TY CỔ PHẦN THƯƠNG MẠI VÀ DỊCH VỤ TAT</span>
                    <a href="{{ route('client.about') }}">Giới thiệu</a>
                    <a href="#">Hỗ trợ khách hàng</a>
                </div>
            </div>
        </footer>
    </div>

    <div class="floating-hotline">
        <span class="floating-hotline__icon">&#9742;</span>
        <div>
            <small>Hỗ trợ trực tuyến</small>
            <strong>0968 498 556</strong>
        </div>
    </div>
</body>
</html>
