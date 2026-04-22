@extends('admin.layouts.app')

@section('admin_page', 'products-show')
@section('title', 'Chi tiết sản phẩm')
@section('eyebrow', 'Products')
@section('description', 'Xem đầy đủ cấu hình thông tin và toàn bộ hình ảnh của sản phẩm trong một màn hình.')

@section('actions')
    <a href="{{ route('admin.products.edit', $product) }}" class="btn">Chỉnh sửa</a>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection

@section('content')
    @php
        $galleryImages = collect([$product->image])
            ->merge($product->productImages->pluck('image'))
            ->filter()
            ->unique()
            ->values();
    @endphp

    <section class="surface-grid surface-grid--detail">
        <article class="surface-panel detail-panel">
            <div class="detail-list">
                <div class="detail-item">
                    <span>ID</span>
                    <strong>#{{ $product->id }}</strong>
                </div>
                <div class="detail-item">
                    <span>Tên sản phẩm</span>
                    <strong>{{ $product->name }}</strong>
                </div>
                <div class="detail-item">
                    <span>Slug</span>
                    <strong>{{ $product->slug }}</strong>
                </div>
                <div class="detail-item">
                    <span>Danh mục</span>
                    <strong>{{ $product->category?->name ?? 'Chưa gán danh mục' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Giá bán</span>
                    <strong>{{ number_format((float) $product->price, 0, ',', '.') }} đ</strong>
                </div>
                <div class="detail-item">
                    <span>Tồn kho</span>
                    <strong>{{ number_format($product->quantity) }}</strong>
                </div>
                <div class="detail-item">
                    <span>Chất liệu / Màu sắc</span>
                    <strong>{{ $product->material ?: 'Chưa có' }} / {{ $product->color ?: 'Chưa có' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Mô tả</span>
                    <strong>{{ $product->description ?: 'Chưa có mô tả.' }}</strong>
                </div>
            </div>
        </article>

        <article class="surface-panel media-panel">
            <div class="panel-kicker">Hình ảnh</div>
            <h2>Bộ ảnh sản phẩm</h2>

            @if ($galleryImages->count())
                <div class="product-admin-gallery">
                    <figure class="product-admin-gallery__primary">
                        <img src="{{ asset('storage/' . $galleryImages->first()) }}" alt="{{ $product->name }} - ảnh đại diện">
                        <figcaption>Ảnh đại diện</figcaption>
                    </figure>

                    <div class="product-admin-gallery__grid">
                        @foreach ($galleryImages as $image)
                            <article class="product-admin-gallery__item">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }} - ảnh {{ $loop->iteration }}">
                                <span>{{ $loop->first ? 'Ảnh đại diện' : 'Ảnh '.$loop->iteration }}</span>
                            </article>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <strong>Chưa có ảnh sản phẩm</strong>
                    <p>Sản phẩm này chưa được tải lên hình ảnh.</p>
                </div>
            @endif
        </article>
    </section>
@endsection
