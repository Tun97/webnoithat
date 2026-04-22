@extends('admin.layouts.app')

@section('admin_page', 'products-edit')
@section('title', 'Sửa sản phẩm')
@section('eyebrow', 'Products')
@section('description', 'Cập nhật dữ liệu sản phẩm và bộ ảnh hiển thị. Nếu chọn bộ ảnh mới, ảnh đầu tiên trong lần chọn sẽ là ảnh đại diện.')

@section('actions')
    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">Xem chi tiết</a>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection

@section('content')
    @php
        $currentImages = collect([$product->image])
            ->merge($product->productImages->pluck('image'))
            ->filter()
            ->unique()
            ->values();
    @endphp

    <section class="surface-grid surface-grid--form">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="surface-panel" data-slug-form>
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="field">
                    <label for="category_id">Danh mục</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Chọn danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required data-slug-source>
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" required data-slug-target>
                    @error('slug')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="price">Giá bán</label>
                    <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                    @error('price')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="quantity">Số lượng tồn</label>
                    <input type="number" min="0" id="quantity" name="quantity" value="{{ old('quantity', $product->quantity) }}" required>
                    @error('quantity')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="material">Chất liệu</label>
                    <input type="text" id="material" name="material" value="{{ old('material', $product->material) }}">
                    @error('material')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="color">Màu sắc</label>
                    <input type="text" id="color" name="color" value="{{ old('color', $product->color) }}">
                    @error('color')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="images">Thay bộ ảnh sản phẩm</label>
                    <input type="file" id="images" name="images[]" accept=".jpg,.jpeg,.png,.webp" multiple data-product-images-input>
                    <div class="helper">Bỏ trống nếu muốn giữ nguyên bộ ảnh hiện tại. Khi chọn ảnh mới, toàn bộ ảnh cũ sẽ được thay thế.</div>
                    @error('images')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                    @if ($errors->has('images.*'))
                        <div class="field-error">{{ $errors->first('images.*') }}</div>
                    @endif
                </div>

                <div class="field field-full">
                    <label for="description">Mô tả</label>
                    <textarea id="description" name="description" data-autosize>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Cập nhật sản phẩm</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>

        <aside class="surface-panel form-aside">
            <div class="panel-kicker">Xem trước</div>
            <h2>{{ $product->name }}</h2>
            <div class="preview-tile">
                <span>Slug hiện tại</span>
                <strong data-slug-preview>{{ old('slug', $product->slug) }}</strong>
            </div>
            <div class="product-image-preview-grid" data-product-images-preview>
                @forelse ($currentImages as $image)
                    <article class="product-image-preview-card">
                        <img src="{{ asset('storage/' . $image) }}" alt="{{ $product->name }} - ảnh {{ $loop->iteration }}">
                        <span>{{ $loop->first ? 'Ảnh đại diện' : 'Ảnh '.$loop->iteration }}</span>
                    </article>
                @empty
                    <div class="image-placeholder">Chưa có ảnh hiện tại</div>
                @endforelse
            </div>
        </aside>
    </section>
@endsection
