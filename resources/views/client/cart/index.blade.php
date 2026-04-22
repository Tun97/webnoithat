@extends('client.layouts.app')

@section('client_page', 'cart')
@section('title', 'Giỏ hàng')

@php
    $shippingFee = $cartItems->isEmpty() ? 0 : 30000;
    $total = $subtotal + $shippingFee;
@endphp

@section('content')
    <section class="cart-page">
        <div class="cart-page__header">
            <div>
                <p class="cart-page__eyebrow">Tài khoản của bạn</p>
                <h1>Giỏ hàng</h1>
                <p class="cart-page__summary">Chỉ khách hàng đã đăng nhập mới xem được giỏ hàng. Bạn có thể cập nhật số lượng hoặc xóa sản phẩm ngay tại đây.</p>
            </div>

            <a href="{{ route('client.products.index') }}" class="cart-page__continue">Tiếp tục mua sắm</a>
        </div>

        @if (session('status'))
            <div class="cart-flash">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="cart-flash cart-flash--error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if ($cartItems->isEmpty())
            <div class="cart-empty">
                <h2>Giỏ hàng của bạn đang trống</h2>
                <p>Hãy chọn thêm vài sản phẩm để quay lại đây và hoàn tất đơn hàng.</p>
                <a href="{{ route('client.products.index') }}">Xem sản phẩm</a>
            </div>
        @else
            <div class="cart-layout">
                <div class="cart-list">
                    @foreach ($cartItems as $item)
                        <article class="cart-item">
                            <a href="{{ route('client.products.show', $item->product) }}" class="cart-item__media">
                                <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}">
                            </a>

                            <div class="cart-item__body">
                                <div class="cart-item__meta">
                                    <p>{{ $item->product->category?->name ?? 'Nội thất cao cấp' }}</p>
                                    <h2>
                                        <a href="{{ route('client.products.show', $item->product) }}">{{ $item->product->name }}</a>
                                    </h2>
                                </div>

                                <div class="cart-item__price">
                                    {{ number_format((float) $item->price, 0, ',', '.') }} đ
                                </div>

                                <div class="cart-item__actions">
                                    <form action="{{ route('client.cart.update', $item) }}" method="POST" class="cart-quantity">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="quantity" min="1" max="{{ $item->product->quantity }}" value="{{ $item->quantity }}">
                                        <button type="submit">Cập nhật</button>
                                    </form>

                                    <form action="{{ route('client.cart.destroy', $item) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cart-item__remove">Xóa</button>
                                    </form>
                                </div>
                            </div>

                            <div class="cart-item__total">
                                {{ number_format($item->quantity * (float) $item->price, 0, ',', '.') }} đ
                            </div>
                        </article>
                    @endforeach
                </div>

                <aside class="cart-summary">
                    <p class="cart-summary__eyebrow">Tóm tắt đơn hàng</p>
                    <h2>{{ $cartItems->count() }} sản phẩm</h2>

                    <div class="cart-summary__line">
                        <span>Tạm tính</span>
                        <strong>{{ number_format($subtotal, 0, ',', '.') }} đ</strong>
                    </div>

                    <div class="cart-summary__line">
                        <span>Phí vận chuyển</span>
                        <strong>{{ number_format($shippingFee, 0, ',', '.') }} đ</strong>
                    </div>

                    <div class="cart-summary__line cart-summary__line--total">
                        <span>Tổng cộng</span>
                        <strong>{{ number_format($total, 0, ',', '.') }} đ</strong>
                    </div>

                    <p class="cart-summary__note">Giỏ hàng đang được gắn với tài khoản đăng nhập hiện tại của bạn.</p>
                    <a href="{{ route('client.checkout.index') }}" class="cart-summary__cta">Tiến hành thanh toán</a>
                </aside>
            </div>
        @endif
    </section>
@endsection
