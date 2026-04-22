@extends('client.layouts.app')

@section('client_page', 'order-detail')
@section('title', 'Theo dõi đơn hàng #'.$order->id)

@section('content')
    <section class="order-detail-page">
        <div class="orders-page__header">
            <div>
                <p class="orders-page__eyebrow">Theo dõi đơn hàng</p>
                <h1>Đơn hàng #{{ $order->id }}</h1>
                <p class="orders-page__summary">Theo dõi tiến độ xử lý, thông tin giao hàng và các sản phẩm đã đặt trong đơn này.</p>
            </div>

            <a href="{{ route('client.orders.index') }}" class="orders-page__link">Xem tất cả đơn hàng</a>
        </div>

        @if (session('status'))
            <div class="orders-flash">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="orders-flash orders-flash--error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="order-detail-layout">
            <div class="order-detail-stack">
                <article class="order-detail-card">
                    <div class="order-detail-card__head">
                        <div>
                            <p>Trạng thái hiện tại</p>
                            <h2>{{ $statusLabels[$order->order_status] ?? $order->order_status }}</h2>
                        </div>
                        <span class="order-card__status order-card__status--{{ $order->order_status }}">
                            {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                        </span>
                    </div>

                    <div class="order-timeline">
                        @foreach ($order->statusHistories as $history)
                            <div class="order-timeline__item">
                                <div class="order-timeline__dot"></div>
                                <div class="order-timeline__content">
                                    <div class="order-timeline__row">
                                        <strong>{{ $history->label }}</strong>
                                        <span>{{ $history->created_at?->format('d/m/Y H:i') }}</span>
                                    </div>
                                    @if ($history->note)
                                        <p>{{ $history->note }}</p>
                                    @endif
                                    @if ($history->changedBy)
                                        <small>Cập nhật bởi: {{ $history->changedBy->name }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </article>

                <article class="order-detail-card">
                    <p class="order-detail-card__eyebrow">Sản phẩm đã đặt</p>
                    <div class="order-products">
                        @foreach ($order->orderItems as $item)
                            <div class="order-products__item">
                                <div>
                                    <strong>{{ $item->product_name }}</strong>
                                    <span>Số lượng: {{ $item->quantity }}</span>
                                </div>
                                <b>{{ number_format((float) $item->subtotal, 0, ',', '.') }} đ</b>
                            </div>
                        @endforeach
                    </div>
                </article>
            </div>

            <aside class="order-detail-card">
                <p class="order-detail-card__eyebrow">Thông tin giao hàng</p>

                <div class="order-info">
                    <div class="order-info__line">
                        <span>Người nhận</span>
                        <strong>{{ $order->customer_name }}</strong>
                    </div>
                    <div class="order-info__line">
                        <span>Số điện thoại</span>
                        <strong>{{ $order->phone }}</strong>
                    </div>
                    <div class="order-info__line">
                        <span>Địa chỉ</span>
                        <strong>{{ $order->address }}</strong>
                    </div>
                    <div class="order-info__line">
                        <span>Thanh toán</span>
                        <div class="order-info__value">
                            <strong>{{ $order->paymentMethodLabel() }}</strong>
                            <em class="order-payment-status order-payment-status--{{ $order->payment_status }}">
                                {{ $order->paymentStatusLabel() }}
                            </em>
                        </div>
                    </div>
                    <div class="order-info__line">
                        <span>Ghi chú</span>
                        <strong>{{ $order->note ?: 'Không có ghi chú.' }}</strong>
                    </div>
                    <div class="order-info__line order-info__line--total">
                        <span>Tổng cộng</span>
                        <strong>{{ number_format((float) $order->total_amount, 0, ',', '.') }} đ</strong>
                    </div>
                </div>

                @if ($order->payment_method === 'momo' && ! $order->isPaid())
                    <a href="{{ route('client.checkout.momo.redirect', $order) }}" class="order-momo-retry">
                        Thanh toán lại MoMo
                    </a>
                @endif

                @if ($order->payment_method === 'bank_transfer')
                    <div class="order-bank-transfer">
                        <p class="order-bank-transfer__eyebrow">VietQR</p>

                        @if ($bankTransfer)
                            <img
                                src="{{ $bankTransfer['qr_url'] }}"
                                alt="VietQR {{ $bankTransfer['content'] }}"
                                class="order-bank-transfer__qr"
                                loading="lazy"
                            >

                            <div class="order-bank-transfer__details">
                                <div>
                                    <span>Ngân hàng</span>
                                    <strong>{{ $bankTransfer['bank'] }}</strong>
                                </div>
                                <div>
                                    <span>Số tài khoản</span>
                                    <strong>{{ $bankTransfer['account'] }}</strong>
                                </div>
                                @if ($bankTransfer['account_name'])
                                    <div>
                                        <span>Người nhận</span>
                                        <strong>{{ $bankTransfer['account_name'] }}</strong>
                                    </div>
                                @endif
                                <div>
                                    <span>Số tiền</span>
                                    <strong>{{ number_format($bankTransfer['amount'], 0, ',', '.') }} đ</strong>
                                </div>
                                <div>
                                    <span>Nội dung</span>
                                    <strong>{{ $bankTransfer['content'] }}</strong>
                                </div>
                            </div>

                            @if ($order->bank_transfer_receipt_path)
                                <div class="order-payment-bill">
                                    <span>Bill đã tải lên</span>
                                    <a href="{{ asset('storage/'.$order->bank_transfer_receipt_path) }}" target="_blank" rel="noopener">
                                        {{ $order->bank_transfer_receipt_original_name ?: 'Xem bill thanh toán' }}
                                    </a>
                                    @if ($order->bank_transfer_receipt_uploaded_at)
                                        <small>{{ $order->bank_transfer_receipt_uploaded_at->format('d/m/Y H:i') }}</small>
                                    @endif
                                </div>
                            @elseif (! $order->isPaid())
                                <form
                                    action="{{ route('client.orders.bank-transfer.confirm', $order) }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    class="order-bank-transfer__form"
                                >
                                    @csrf
                                    <label>
                                        <span>Bill chuyển khoản</span>
                                        <input type="file" name="payment_bill" accept="image/*,.pdf" required>
                                    </label>
                                    <button type="submit">Xác nhận đã thanh toán</button>
                                </form>
                            @endif
                        @else
                            <p class="order-bank-transfer__empty">Chưa cấu hình tài khoản nhận chuyển khoản.</p>
                        @endif
                    </div>
                @endif
            </aside>
        </div>
    </section>
@endsection
