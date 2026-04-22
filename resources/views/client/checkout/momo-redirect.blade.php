@extends('client.layouts.app')

@section('client_page', 'checkout')
@section('title', 'Thanh toán MoMo')

@section('content')
    <section class="momo-redirect-page">
        <article class="momo-redirect-card">
            <p class="checkout-card__eyebrow">MoMo</p>
            <h1>Đang mở thanh toán MoMo</h1>
            <p>Đơn hàng #{{ $order->id }} sẽ được chuyển sang trang quét QR của MoMo.</p>
            <a href="{{ $payUrl }}">Mở lại trang MoMo</a>
        </article>
    </section>

    <script>
        (() => {
            const storageKey = @json('momo-payment-'.$order->id.'-'.$order->momo_request_id);
            const payUrl = @json($payUrl);
            const completeUrl = @json($returnUrl);

            const markComplete = () => {
                sessionStorage.removeItem(storageKey);
                window.location.replace(completeUrl + (completeUrl.includes('?') ? '&' : '?') + 'from=browser_back');
            };

            window.addEventListener('pageshow', (event) => {
                if (event.persisted && sessionStorage.getItem(storageKey) === 'started') {
                    markComplete();
                }
            });

            if (sessionStorage.getItem(storageKey) === 'started') {
                markComplete();
                return;
            }

            sessionStorage.setItem(storageKey, 'started');
            window.location.assign(payUrl);
        })();
    </script>
@endsection
