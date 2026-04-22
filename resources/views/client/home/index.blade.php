@extends('client.layouts.app')

@section('client_page', 'home')
@section('title', 'Trang chủ nội thất')

@section('content')
    <div class="home-stack">
        @forelse ($sections as $section)
            <section class="section-showcase">
                <div class="section-head">
                    <div class="section-title">
                        <span class="section-title__icon">✦</span>
                        <strong>{{ $section['title'] }}</strong>
                    </div>

                    <div class="section-links">
                        @foreach ($section['links'] as $link)
                            <a href="#">{{ $link }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="showcase-grid">
                    <article class="product-card">
                        <a href="{{ $section['side_left']['url'] }}">
                            <div class="product-card__media">
                                <img src="{{ $section['side_left']['image'] }}" alt="{{ $section['side_left']['title'] }}">
                            </div>
                            <div class="product-card__body">
                                <div class="product-card__title">{{ $section['side_left']['title'] }}</div>
                                <div class="price-line">
                                    @if ($section['side_left']['price'] === 'Liên hệ')
                                        <span class="contact-link">{{ $section['side_left']['price'] }}</span>
                                    @else
                                        <span class="price-current">{{ $section['side_left']['price'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </article>

                    <article class="hero-card">
                        <div class="product-card__media">
                            <img src="{{ $section['hero_image'] }}" alt="{{ $section['hero_title'] }}">
                        </div>
                        <div class="hero-card__overlay">
                            <div class="hero-card__inner">
                                <h2>{{ $section['hero_title'] }}</h2>
                                <p>{{ $section['hero_subtitle'] }}</p>
                                <a href="#">Xem thêm</a>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <a href="{{ $section['side_right']['url'] }}">
                            <div class="product-card__media">
                                <img src="{{ $section['side_right']['image'] }}" alt="{{ $section['side_right']['title'] }}">
                            </div>
                            <div class="product-card__body">
                                <div class="product-card__title">{{ $section['side_right']['title'] }}</div>
                                <div class="price-line">
                                    @if ($section['side_right']['price'] === 'Liên hệ')
                                        <span class="contact-link">{{ $section['side_right']['price'] }}</span>
                                    @else
                                        <span class="price-current">{{ $section['side_right']['price'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </article>
                </div>

                <div class="products-grid">
                    @foreach ($section['products'] as $product)
                        <article class="product-card">
                            <a href="{{ $product['url'] }}">
                                <div class="product-card__media">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}">
                                </div>
                                <div class="product-card__body">
                                    <div class="product-card__title">{{ $product['title'] }}</div>
                                    <div class="price-line">
                                        @if ($product['price'] === 'Liên hệ')
                                            <span class="contact-link">{{ $product['price'] }}</span>
                                        @else
                                            <span class="price-current">{{ $product['price'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        @empty
            <div class="product-card">
                <div class="product-card__body">
                    <div class="product-card__title">Chưa có dữ liệu sản phẩm để hiển thị trên trang chủ.</div>
                </div>
            </div>
        @endforelse
    </div>
@endsection
