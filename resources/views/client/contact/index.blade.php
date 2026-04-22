@extends('client.layouts.app')

@section('client_page', 'contact')
@section('title', 'Liên hệ')

@section('content')
    <section class="contact-page">
        <nav class="contact-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('client.home') }}">Trang chủ</a>
            <span>Liên hệ</span>
        </nav>

        <div class="contact-heading">
            <h1>LIÊN HỆ VỚI TAT</h1>

            <div class="contact-info-row">
                <div>
                    <span>☎</span>
                    <p>Điện thoại <strong>{{ $contactInfo['phone'] }}</strong></p>
                </div>
                <div>
                    <span>✉</span>
                    <p>Email <strong>{{ $contactInfo['email'] }}</strong></p>
                </div>
                <div>
                    <span>e</span>
                    <p>Website <a href="{{ $contactInfo['website'] }}" target="_blank" rel="noopener">{{ $contactInfo['website'] }}</a></p>
                </div>
            </div>

            <p>Xin chào! Cảm ơn bạn đã quan tâm đến sản phẩm của TAT Home.</p>
            <p>Nếu bạn có bất kỳ thắc mắc hoặc góp ý dịch vụ nào, xin vui lòng gửi thông tin đến chúng tôi bên dưới. Chân thành cảm ơn!</p>
        </div>

        @if (session('status'))
            <div class="contact-flash">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="contact-flash contact-flash--error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('client.contact.store') }}" method="POST" class="contact-form">
            @csrf
            <div class="contact-form__grid">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Họ và tên" required>
                <input
                    type="tel"
                    name="phone"
                    value="{{ old('phone') }}"
                    placeholder="Số điện thoại"
                    inputmode="tel"
                    autocomplete="tel"
                    pattern="(?:0[35789](?:[\s.\-]?[0-9]){8}|\+84[35789](?:[\s.\-]?[0-9]){8})"
                    title="Nhập số di động Việt Nam, ví dụ 0977665554 hoặc +84977665554"
                    required
                >
            </div>
            <textarea name="message" rows="7" placeholder="Nhập nội dung liên hệ" required>{{ old('message') }}</textarea>
            <button type="submit">GỬI LIÊN HỆ</button>
        </form>

        <div class="contact-map">
            <iframe
                title="Bản đồ TAT Home"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d782.8368188502757!2d105.74183876142982!3d21.039874847966285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135096b31fa7abb%3A0xff645782804911af!2zVHLGsOG7nW5nIMSR4bqhaSBo4buNYyBDw7RuZyBuZ2jhu4cgxJDDtG5nIMOB!5e0!3m2!1svi!2s!4v1776761253314!5m2!1svi!2s"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                allowfullscreen>
            </iframe>
        </div>

        <div class="contact-consultants">
            @foreach ($consultants as $consultant)
                <article class="contact-consultant">
                    <img src="{{ $consultant['image'] }}" alt="Tư vấn viên {{ $consultant['name'] }}" loading="lazy">
                    <div>
                        <p>Tư vấn viên:</p>
                        <strong>{{ $consultant['name'] }}</strong>
                        <div class="contact-consultant__actions">
                            <a href="#">Zalo</a>
                            <!-- <a href="#">Facebook</a> -->
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endsection
