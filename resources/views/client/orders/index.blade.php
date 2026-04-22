@extends('client.layouts.app')

@section('client_page', 'orders')
@section('title', 'Đơn hàng của tôi')

@section('content')
    <section class="orders-page">
        <div class="orders-page__header">
            <div>
                <p class="orders-page__eyebrow">Theo dõi mua sắm</p>
                <h1>Đơn hàng của tôi</h1>
                <p class="orders-page__summary">Xem tiến độ xử lý đơn mới nhất và toàn bộ lịch sử đặt hàng trước đây của bạn.</p>
            </div>

            <a href="{{ route('client.products.index') }}" class="orders-page__link">Tiếp tục mua sắm</a>
        </div>

        @if (session('status'))
            <div class="orders-flash">{{ session('status') }}</div>
        @endif

        @if ($orders->count() === 0)
            <div class="orders-empty">
                <h2>Bạn chưa có đơn hàng nào</h2>
                <p>Hãy chọn sản phẩm yêu thích và hoàn tất thanh toán để bắt đầu theo dõi đơn hàng tại đây.</p>
                <a href="{{ route('client.products.index') }}">Khám phá sản phẩm</a>
            </div>
        @else
            <div class="orders-list">
                @foreach ($orders as $order)
                    @php
                        $latestHistory = $order->statusHistories->first();
                    @endphp
                    <article class="order-card">
                        <div class="order-card__head">
                            <div>
                                <p>#{{ $order->id }}</p>
                                <h2>Đơn hàng ngày {{ $order->created_at?->format('d/m/Y H:i') }}</h2>
                            </div>
                            <span class="order-card__status order-card__status--{{ $order->order_status }}">
                                {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                            </span>
                        </div>

                        <div class="order-card__meta">
                            <div>
                                <span>Người nhận</span>
                                <strong>{{ $order->customer_name }}</strong>
                            </div>
                            <div>
                                <span>Thanh toán</span>
                                <strong>{{ $order->paymentMethodLabel() }}</strong>
                                <em class="order-payment-status order-payment-status--{{ $order->payment_status }}">
                                    {{ $order->paymentStatusLabel() }}
                                </em>
                            </div>
                            <div>
                                <span>Tổng tiền</span>
                                <strong>{{ number_format((float) $order->total_amount, 0, ',', '.') }} đ</strong>
                            </div>
                            <div>
                                <span>Sản phẩm</span>
                                <strong>{{ $order->orderItems->sum('quantity') }} món</strong>
                            </div>
                        </div>

                        @if ($latestHistory)
                            <p class="order-card__note">{{ $latestHistory->note }}</p>
                        @endif

                        <div class="order-card__actions">
                            <a href="{{ route('client.orders.show', $order) }}">Xem chi tiết & tiến độ</a>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($orders->hasPages())
                <nav class="orders-pagination" aria-label="Phân trang đơn hàng">
                    @if ($orders->onFirstPage())
                        <span class="orders-pagination__item is-disabled">Trước</span>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}" class="orders-pagination__item">Trước</a>
                    @endif

                    @foreach ($orders->getUrlRange(max(1, $orders->currentPage() - 1), min($orders->lastPage(), $orders->currentPage() + 1)) as $page => $url)
                        <a href="{{ $url }}" @class(['orders-pagination__item', 'is-active' => $page === $orders->currentPage()])>
                            {{ $page }}
                        </a>
                    @endforeach

                    @if ($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}" class="orders-pagination__item">Sau</a>
                    @else
                        <span class="orders-pagination__item is-disabled">Sau</span>
                    @endif
                </nav>
            @endif
        @endif
    </section>
@endsection
