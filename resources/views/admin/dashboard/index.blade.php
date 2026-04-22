@extends('admin.layouts.app')

@section('admin_page', 'dashboard-index')
@section('title', 'Tổng quan')
@section('eyebrow', 'Dashboard')
@section('description', 'Theo dõi nhanh doanh thu, đơn hàng, sản phẩm bán chạy và các tác vụ quản trị chính.')

@section('actions')
    <a href="{{ route('admin.products.create') }}" class="btn">Thêm sản phẩm</a>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Xem đơn hàng</a>
@endsection

@section('content')
    <section class="dashboard-grid">
        <article class="stat-card stat-card--featured" data-stat-card data-stat-kind="currency" data-stat-value="{{ (int) $totalRevenue }}">
            <span>Doanh thu đã thanh toán</span>
            <strong>{{ number_format((float) $totalRevenue, 0, ',', '.') }} đ</strong>
            <p>Tổng doanh thu từ các đơn hàng đã ghi nhận thanh toán.</p>
        </article>
        <article class="stat-card" data-stat-card data-stat-kind="number" data-stat-value="{{ (int) $totalOrders }}">
            <span>Đơn hàng</span>
            <strong>{{ number_format($totalOrders) }}</strong>
            <p>Số đơn đã được ghi nhận để theo dõi xử lý và thanh toán.</p>
        </article>
        <article class="stat-card" data-stat-card data-stat-kind="number" data-stat-value="{{ (int) $totalProducts }}">
            <span>Sản phẩm</span>
            <strong>{{ number_format($totalProducts) }}</strong>
            <p>Kho dữ liệu sản phẩm đang được duy trì trên hệ thống.</p>
        </article>
        <article class="stat-card" data-stat-card data-stat-kind="number" data-stat-value="{{ (int) $totalCustomers }}">
            <span>Khách hàng</span>
            <strong>{{ number_format($totalCustomers) }}</strong>
            <p>Tổng số tài khoản khách hiện hữu trong hệ thống bán hàng.</p>
        </article>
        <article class="stat-card" data-stat-card data-stat-kind="number" data-stat-value="{{ (int) $totalContacts }}">
            <span>Liên hệ</span>
            <strong>{{ number_format($totalContacts) }}</strong>
            <p>Tin nhắn tư vấn và phản hồi khách gửi từ trang liên hệ.</p>
        </article>
    </section>

    <section class="surface-grid surface-grid--charts">
        <article class="surface-panel dashboard-chart dashboard-chart--revenue">
            <div class="panel-kicker">Doanh thu</div>
            <h2>Thống kê doanh thu 6 tháng</h2>
            <div class="revenue-chart" aria-label="Biểu đồ doanh thu 6 tháng">
                @foreach ($revenueChart as $point)
                    <div class="revenue-chart__item">
                        <div class="revenue-chart__track">
                            <span class="revenue-chart__bar" style="--bar-height: {{ $point['percentage'] }}%;"></span>
                        </div>
                        <strong>{{ number_format($point['value'], 0, ',', '.') }} đ</strong>
                        <span>{{ $point['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </article>

        <article class="surface-panel dashboard-chart">
            <div class="panel-kicker">Đơn hàng</div>
            <h2>Thống kê trạng thái đơn</h2>
            <div class="status-chart">
                @foreach ($orderStatusChart as $point)
                    <div class="status-chart__row">
                        <div>
                            <strong>{{ $point['label'] }}</strong>
                            <span>{{ number_format($point['count']) }} đơn</span>
                        </div>
                        <div class="status-chart__track">
                            <span class="status-chart__bar status-chart__bar--{{ $point['status'] }}" style="--bar-width: {{ $point['percentage'] }}%;"></span>
                        </div>
                    </div>
                @endforeach
            </div>
        </article>
    </section>

    <section class="surface-grid surface-grid--dashboard">
        <article class="surface-panel dashboard-chart">
            <div class="panel-kicker">Sản phẩm</div>
            <h2>Sản phẩm bán chạy</h2>
            @if ($topProductChart->count())
                <div class="top-product-chart">
                    @foreach ($topProductChart as $product)
                        <div class="top-product-chart__row">
                            <div class="top-product-chart__meta">
                                <strong>{{ $product['name'] }}</strong>
                                <span>{{ number_format($product['quantity']) }} sản phẩm · {{ number_format($product['amount'], 0, ',', '.') }} đ</span>
                            </div>
                            <div class="top-product-chart__track">
                                <span style="--bar-width: {{ $product['percentage'] }}%;"></span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state empty-state--compact">
                    <strong>Chưa có dữ liệu bán chạy</strong>
                    <p>Biểu đồ sẽ hiển thị khi đơn hàng bắt đầu phát sinh sản phẩm.</p>
                </div>
            @endif
        </article>

        <article class="surface-panel surface-panel--accent">
            <div class="panel-kicker">Đi nhanh</div>
            <h2>Khu vực thao tác chính</h2>
            <div class="quick-link-grid">
                <a href="{{ route('admin.categories.index') }}" class="quick-link">
                    <strong>Danh mục</strong>
                    <span>Quản lý cấu trúc phân loại sản phẩm.</span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="quick-link">
                    <strong>Sản phẩm</strong>
                    <span>Kiểm tra kho, giá bán và hình ảnh hiển thị.</span>
                </a>
                <a href="{{ route('admin.contacts.index') }}" class="quick-link">
                    <strong>Liên hệ</strong>
                    <span>Xem tin nhắn tư vấn và phản hồi của khách hàng.</span>
                </a>
                <a href="{{ route('admin.customers.index') }}" class="quick-link">
                    <strong>Khách hàng</strong>
                    <span>Xem hồ sơ và lịch sử mua sắm của người dùng.</span>
                </a>
            </div>
        </article>
    </section>
@endsection
