@extends('admin.layouts.app')

@section('admin_page', 'products-create')
@section('title', 'Thêm sản phẩm')
@section('eyebrow', 'Products')
@section('description', 'Tạo mới sản phẩm với thông tin danh mục, giá bán, tồn kho và bộ ảnh sản phẩm. Ảnh đầu tiên trong bộ ảnh sẽ là ảnh đại diện.')

@section('actions')
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
@endsection

@section('content')
    <section class="surface-grid surface-grid--form">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="surface-panel" data-slug-form>
            @csrf

            <div class="form-grid">
                <div class="field">
                    <label for="category_id">Danh mục</label>
                    <select id="category_id" name="category_id" required>
                        <option value="">Chọn danh mục</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required data-slug-source>
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required data-slug-target>
                    @error('slug')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="price">Giá bán</label>
                    <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price') }}" required>
                    @error('price')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="quantity">Số lượng tồn</label>
                    <input type="number" min="0" id="quantity" name="quantity" value="{{ old('quantity') }}" required>
                    @error('quantity')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="material">Chất liệu</label>
                    <input type="text" id="material" name="material" value="{{ old('material') }}">
                    @error('material')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="color">Màu sắc</label>
                    <input type="text" id="color" name="color" value="{{ old('color') }}">
                    @error('color')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="images">Ảnh sản phẩm</label>
                    <input type="file" id="images" name="images[]" accept=".jpg,.jpeg,.png,.webp" multiple data-product-images-input>
                    <div class="helper">Có thể chọn nhiều ảnh JPG, PNG hoặc WEBP, tối đa 2MB mỗi ảnh. Ảnh đầu tiên sẽ là ảnh đại diện.</div>
                    @error('images')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                    @if ($errors->has('images.*'))
                        <div class="field-error">{{ $errors->first('images.*') }}</div>
                    @endif
                </div>

                <div class="field field-full">
                    <label for="description">Mô tả</label>
                    <textarea id="description" name="description" data-autosize>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Lưu sản phẩm</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>

        <aside class="surface-panel form-aside">
            <div class="panel-kicker">Xem trước</div>
            <h2>Hình ảnh và định danh</h2>
            <div class="preview-tile">
                <span>Slug dự kiến</span>
                <strong data-slug-preview>{{ old('slug') ?: 'slug-san-pham' }}</strong>
            </div>
            <div class="product-image-preview-grid" data-product-images-preview>
                <div class="image-placeholder">Chưa chọn ảnh sản phẩm</div>
            </div>
        </aside>
    </section>
@endsection
