@extends('client.layouts.app')

@section('client_page', 'product-detail')
@section('title', $product->name)

@section('content')
    <div class="product-detail">
        <nav class="product-detail__breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('client.home') }}">Trang chủ</a>
            <span>/</span>
            <a href="{{ route('client.products.index') }}">Sản phẩm</a>
            @if ($product->category)
                <span>/</span>
                <a href="{{ route('client.products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
            @endif
            <span>/</span>
            <strong>{{ $product->name }}</strong>
        </nav>

        <section class="product-detail__hero">
            <div class="product-gallery" data-product-gallery>
                <div class="product-gallery__main">
                    <img
                        src="{{ $galleryImages->first()['image'] }}"
                        alt="{{ $galleryImages->first()['alt'] }}"
                        data-gallery-main
                    >
                </div>

                <div class="product-gallery__thumbs">
                    @foreach ($galleryImages as $image)
                        <button
                            type="button"
                            class="product-gallery__thumb @if ($loop->first) is-active @endif"
                            data-gallery-thumb
                            data-image="{{ $image['image'] }}"
                            data-alt="{{ $image['alt'] }}"
                            aria-label="Xem ảnh {{ $loop->iteration }} của {{ $product->name }}"
                        >
                            <img src="{{ $image['image'] }}" alt="{{ $image['alt'] }}">
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="product-detail__summary">
                <p class="product-detail__category">{{ $product->category?->name ?? 'Nội thất cao cấp' }}</p>
                <h1>{{ $product->name }}</h1>
                <div class="product-detail__price">{{ $priceText }}</div>

                <div class="product-detail__meta">
                    <div class="product-detail__meta-item">
                        <span>Chất liệu</span>
                        <strong>{{ $product->material ?: 'Đang cập nhật' }}</strong>
                    </div>
                    <div class="product-detail__meta-item">
                        <span>Màu sắc</span>
                        <strong>{{ $product->color ?: 'Đang cập nhật' }}</strong>
                    </div>
                    <div class="product-detail__meta-item">
                        <span>Tình trạng</span>
                        <strong>{{ $product->quantity > 0 ? 'Còn '.$product->quantity.' sản phẩm' : 'Nhận đặt hàng' }}</strong>
                    </div>
                </div>

                <div class="product-detail__actions">
                    @auth
                        <form action="{{ route('client.cart.store', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="product-detail__cart-button">Thêm vào giỏ hàng</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="product-detail__cart-button">Đăng nhập để thêm vào giỏ</a>
                    @endauth
                </div>
            </div>
        </section>

        <section class="product-description" data-description>
            <div class="product-description__head">
                <h2>Mô tả sản phẩm</h2>
                <button type="button" class="product-description__toggle" data-description-toggle>
                    Xem thêm mô tả
                </button>
            </div>

            <div class="product-description__body" data-description-body>
                {!! nl2br(e($product->description ?: 'Mô tả chi tiết của sản phẩm đang được cập nhật. Vui lòng liên hệ để nhận thêm thông tin về kích thước, chất liệu và phương án giao hàng.')) !!}
            </div>
        </section>

        @if ($relatedProducts->isNotEmpty())
            <section class="related-products">
                <div class="related-products__head">
                    <p class="related-products__eyebrow">{{ $product->category?->name ?? 'Nội thất cao cấp' }}</p>
                    <h2>Sản phẩm liên quan</h2>
                </div>

                <div class="related-products__grid">
                    @foreach ($relatedProducts as $relatedProduct)
                        <article class="catalog-card">
                            <a href="{{ $relatedProduct['url'] }}">
                                <div class="catalog-card__media">
                                    <img src="{{ $relatedProduct['image'] }}" alt="{{ $relatedProduct['title'] }}">
                                    <span class="catalog-card__badge">{{ $relatedProduct['badge'] }}</span>
                                </div>

                                <div class="catalog-card__body">
                                    <div class="catalog-card__category">{{ $relatedProduct['category'] }}</div>
                                    <h3>{{ $relatedProduct['title'] }}</h3>
                                    <p>{{ $relatedProduct['details'] }}</p>

                                    <div class="catalog-card__footer">
                                        <span class="catalog-card__price">{{ $relatedProduct['price'] }}</span>
                                        <span class="catalog-card__stock">{{ $relatedProduct['stock'] }}</span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
@endsection
