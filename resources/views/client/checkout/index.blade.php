@extends('client.layouts.app')

@section('client_page', 'checkout')
@section('title', 'Thanh toán')

@section('content')
    <section class="checkout-page">
        <div class="checkout-page__header">
            <div>
                <p class="checkout-page__eyebrow">Xác nhận đơn hàng</p>
                <h1>Thanh toán</h1>
                <p class="checkout-page__summary">Chọn đúng Tỉnh, Quận, Phường theo GHN để tiện tính phí và tạo đơn giao hàng sau này.</p>
            </div>

            <a href="{{ route('client.cart.index') }}" class="checkout-page__back">Quay lại giỏ hàng</a>
        </div>

        @if ($errors->any())
            <div class="checkout-flash checkout-flash--error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="checkout-layout">
            <form action="{{ route('client.checkout.store') }}" method="POST" class="checkout-form">
                @csrf

                <div class="checkout-card">
                    <p class="checkout-card__eyebrow">Thông tin người nhận</p>

                    <div class="checkout-grid">
                        <label class="checkout-field">
                            <span>Họ và tên</span>
                            <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}" required>
                        </label>

                        <label class="checkout-field">
                            <span>Số điện thoại</span>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required>
                        </label>
                    </div>

                    @include('client.partials.address-selector', [
                        'provinceId' => $user->province_id,
                        'provinceName' => $user->province_name,
                        'districtId' => $user->district_id,
                        'districtName' => $user->district_name,
                        'wardCode' => $user->ward_code,
                        'wardName' => $user->ward_name,
                    ])

                    <label class="checkout-field">
                        <span>Địa chỉ chi tiết</span>
                        <textarea name="address_line" rows="4" required>{{ old('address_line', $user->address_line) }}</textarea>
                    </label>
                </div>

                <div class="checkout-card">
                    <p class="checkout-card__eyebrow">Thanh toán và ghi chú</p>

                    <div class="checkout-payment">
                        <label class="checkout-payment__option">
                            <input type="radio" name="payment_method" value="cod" @checked(old('payment_method', 'cod') === 'cod')>
                            <span>Thanh toán khi nhận hàng</span>
                        </label>

                        <label class="checkout-payment__option">
                            <input type="radio" name="payment_method" value="bank_transfer" @checked(old('payment_method') === 'bank_transfer')>
                            <span>Chuyển khoản ngân hàng</span>
                        </label>

                        <label class="checkout-payment__option">
                            <input type="radio" name="payment_method" value="momo" @checked(old('payment_method') === 'momo')>
                            <span>Ví MoMo</span>
                        </label>
                    </div>

                    <label class="checkout-field">
                        <span>Ghi chú</span>
                        <textarea name="note" rows="4" placeholder="Ví dụ: giao giờ hành chính, gọi trước khi giao...">{{ old('note') }}</textarea>
                    </label>
                </div>

                <button type="submit" class="checkout-submit">Đặt hàng</button>
            </form>

            <aside class="checkout-summary">
                <p class="checkout-card__eyebrow">Đơn hàng của bạn</p>

                <div class="checkout-summary__items">
                    @foreach ($cartItems as $item)
                        <article class="checkout-summary__item">
                            <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}">
                            <div>
                                <strong>{{ $item->product->name }}</strong>
                                <span>Số lượng: {{ $item->quantity }}</span>
                            </div>
                            <b>{{ number_format($item->quantity * (float) $item->price, 0, ',', '.') }} đ</b>
                        </article>
                    @endforeach
                </div>

                <div class="checkout-summary__line">
                    <span>Tạm tính</span>
                    <strong>{{ number_format($subtotal, 0, ',', '.') }} đ</strong>
                </div>

                <div class="checkout-summary__line">
                    <span>Phí vận chuyển</span>
                    <strong>{{ number_format($shippingFee, 0, ',', '.') }} đ</strong>
                </div>

                <div class="checkout-summary__line checkout-summary__line--total">
                    <span>Tổng cộng</span>
                    <strong>{{ number_format($total, 0, ',', '.') }} đ</strong>
                </div>
            </aside>
        </div>
    </section>
@endsection
