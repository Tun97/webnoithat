@extends('client.layouts.app')

@section('client_page', 'products')
@section('title', $pageHeading)

@section('content')
    <div class="products-page">
        <section class="products-hero" data-slider>
            <div class="products-hero__viewport">
                <div class="products-hero__track" data-slider-track>
                    @foreach ($heroSlides as $slide)
                        <article class="products-hero__slide" data-slide>
                            <div class="products-hero__backdrop" style="background-image: url('{{ $slide['background_image'] }}')"></div>
                            <div class="products-hero__overlay"></div>

                            <div class="products-hero__content">
                                <div class="products-hero__copy">
                                    <span class="products-hero__eyebrow">{{ $slide['eyebrow'] }}</span>

                                    @if ($loop->first)
                                        <h1>{{ $slide['title'] }}</h1>
                                    @else
                                        <h2>{{ $slide['title'] }}</h2>
                                    @endif

                                    <p>{{ $slide['description'] }}</p>
                                    <a href="#product-grid" class="products-hero__cta">Xem sản phẩm</a>
                                </div>

                                <div class="products-hero__visual">
                                    <img src="{{ $slide['product_image'] }}" alt="{{ $slide['title'] }}">
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            @if ($heroSlides->count() > 1)
                <button type="button" class="products-hero__nav products-hero__nav--prev" data-slider-prev aria-label="Banner trước">
                    &#8249;
                </button>
                <button type="button" class="products-hero__nav products-hero__nav--next" data-slider-next aria-label="Banner tiếp theo">
                    &#8250;
                </button>

                <div class="products-hero__dots">
                    @foreach ($heroSlides as $slide)
                        <button
                            type="button"
                            class="products-hero__dot"
                            data-slider-dot
                            data-slide-index="{{ $loop->index }}"
                            aria-label="Chuyển đến banner {{ $loop->iteration }}"
                        ></button>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="products-catalog" id="product-grid">
            <div class="products-catalog__head">
                <p class="products-catalog__eyebrow">{{ $pageHeading }}</p>
                <h2 class="products-catalog__title">Sản phẩm nổi bật</h2>
                <p class="products-catalog__summary">{{ $pageDescription }}</p>

                <div class="products-catalog__tags">
                    <a href="{{ route('client.products.index') }}" @class(['is-active' => ! $selectedCategory && $search === ''])>
                        Tất cả
                    </a>

                    @foreach ($featuredCategories as $featuredCategory)
                        <a
                            href="{{ route('client.products.index', ['category' => $featuredCategory->slug]) }}"
                            @class(['is-active' => request('category') === $featuredCategory->slug])
                        >
                            {{ $featuredCategory->name }}
                        </a>
                    @endforeach
                </div>

                <div class="products-catalog__count">
                    Hiển thị {{ $products->count() }} / {{ $products->total() }} sản phẩm
                </div>
            </div>

            @if ($products->count() > 0)
                <div class="products-grid">
                    @foreach ($products as $product)
                        <article class="catalog-card">
                            <a href="{{ $product['url'] }}">
                                <div class="catalog-card__media">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['title'] }}">
                                    <span class="catalog-card__badge">{{ $product['badge'] }}</span>
                                </div>

                                <div class="catalog-card__body">
                                    <div class="catalog-card__category">{{ $product['category'] }}</div>
                                    <h3>{{ $product['title'] }}</h3>
                                    <p>{{ $product['details'] }}</p>

                                    <div class="catalog-card__footer">
                                        <span class="catalog-card__price">{{ $product['price'] }}</span>
                                        <span class="catalog-card__stock">{{ $product['stock'] }}</span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                @if ($products->hasPages())
                    <nav class="products-pagination" aria-label="Phân trang sản phẩm">
                        @if ($products->onFirstPage())
                            <span class="products-pagination__item is-disabled">Trước</span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="products-pagination__item">Trước</a>
                        @endif

                        @foreach ($products->getUrlRange(max(1, $products->currentPage() - 1), min($products->lastPage(), $products->currentPage() + 1)) as $page => $url)
                            <a href="{{ $url }}" @class(['products-pagination__item', 'is-active' => $page === $products->currentPage()])>
                                {{ $page }}
                            </a>
                        @endforeach

                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="products-pagination__item">Sau</a>
                        @else
                            <span class="products-pagination__item is-disabled">Sau</span>
                        @endif
                    </nav>
                @endif
            @else
                <div class="products-empty">
                    <h3>Chưa tìm thấy sản phẩm phù hợp</h3>
                    <p>Hãy thử lại với từ khóa khác hoặc chọn một danh mục khác trong phần tìm kiếm.</p>
                    <a href="{{ route('client.products.index') }}">Xem toàn bộ sản phẩm</a>
                </div>
            @endif
        </section>
    </div>
@endsection
