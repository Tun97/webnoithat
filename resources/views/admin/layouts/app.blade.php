<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Quản trị') - Admin</title>
    @vite(['resources/css/admin/app.css', 'resources/js/admin/app.js'])
</head>
<body
    class="admin-page admin-page--@yield('admin_page', 'dashboard-index')"
    data-admin-page="@yield('admin_page', 'dashboard-index')"
>
    <div class="admin-shell">
        <aside class="admin-sidebar" data-admin-sidebar>
            <div class="brand">
                <small>Khu vực quản trị</small>
                <strong>Admin TAT</strong>
                <span>Điều hành danh mục, sản phẩm, liên hệ, đơn hàng và khách hàng từ một không gian thống nhất.</span>
            </div>

            <nav class="nav-group">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <span>Tổng quan</span>
                    <span>01</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <span>Danh mục</span>
                    <span>02</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <span>Sản phẩm</span>
                    <span>03</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                    <span>Liên hệ</span>
                    <span>04</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <span>Đơn hàng</span>
                    <span>05</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}" href="{{ route('admin.customers.index') }}">
                    <span>Khách hàng</span>
                    <span>06</span>
                </a>
                <a class="nav-link" href="{{ route('client.home') }}">
                    <span>Về trang chủ</span>
                    <span>↗</span>
                </a>
            </nav>

            <div class="sidebar-panel">
                <span class="sidebar-kicker">Tài khoản đang dùng</span>
                <strong>{{ auth()->user()->name ?? 'Admin' }}</strong>
                <p>{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: 14px;">
                    @csrf
                    <button type="submit" class="btn btn-secondary" style="width: 100%;">Đăng xuất</button>
                </form>
            </div>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <button
                    class="sidebar-toggle"
                    type="button"
                    aria-label="Mở menu quản trị"
                    aria-expanded="false"
                    data-sidebar-toggle
                >
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <div class="topbar-copy">
                    <span>Admin workspace</span>
                    <strong>@yield('title', 'Bảng điều khiển')</strong>
                </div>

                <div class="topbar-meta">
                    <span class="meta-pill">{{ now()->format('d/m/Y') }}</span>
                    <span class="meta-pill meta-pill--soft">{{ auth()->user()->role ?? 'admin' }}</span>
                </div>
            </header>

            <main class="content">
                <div class="page-card">
                    <header class="page-header">
                        <div>
                            <div class="eyebrow">@yield('eyebrow', 'Trang quản trị')</div>
                            <h1>@yield('title', 'Bảng điều khiển')</h1>
                            @hasSection('description')
                                <p>@yield('description')</p>
                            @endif
                        </div>

                        @hasSection('actions')
                            <div class="actions">
                                @yield('actions')
                            </div>
                        @endif
                    </header>

                    <section class="page-body stack">
                        @if (session('success'))
                            <div class="flash flash-success" data-flash-message>
                                <div>
                                    <strong>Thành công</strong>
                                    <p>{{ session('success') }}</p>
                                </div>
                                <button type="button" class="flash-dismiss" data-flash-dismiss aria-label="Đóng thông báo">×</button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="flash flash-error" data-flash-message>
                                <div>
                                    <strong>Có lỗi xảy ra</strong>
                                    <p>{{ session('error') }}</p>
                                </div>
                                <button type="button" class="flash-dismiss" data-flash-dismiss aria-label="Đóng thông báo">×</button>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="flash flash-error flash-block">
                                <div>
                                    <strong>Dữ liệu chưa hợp lệ</strong>
                                    <ul class="error-list">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </section>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
