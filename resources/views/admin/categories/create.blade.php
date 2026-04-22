@extends('admin.layouts.app')

@section('admin_page', 'categories-create')
@section('title', 'Thêm danh mục')
@section('eyebrow', 'Categories')
@section('description', 'Tạo danh mục mới và chuẩn hóa slug ngay từ đầu để việc điều hướng và quản lý dữ liệu nhất quán hơn.')

@section('actions')
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
@endsection

@section('content')
    <section class="surface-grid surface-grid--form">
        <form action="{{ route('admin.categories.store') }}" method="POST" class="surface-panel" data-slug-form>
            @csrf

            <div class="form-grid">
                <div class="field">
                    <label for="name">Tên danh mục</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required data-slug-source>
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" required data-slug-target>
                    <div class="helper">Slug sẽ được gợi ý tự động khi bạn nhập tên.</div>
                    @error('slug')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
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
                <button type="submit" class="btn">Lưu danh mục</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>

        <aside class="surface-panel form-aside">
            <div class="panel-kicker">Xem trước</div>
            <h2>Nhận diện danh mục</h2>
            <div class="preview-tile">
                <span>Slug dự kiến</span>
                <strong data-slug-preview>{{ old('slug') ?: 'slug-danh-muc' }}</strong>
            </div>
            <p>Một slug ngắn, rõ nghĩa sẽ giúp liên kết gọn hơn và dễ theo dõi trong khu vực quản trị.</p>
        </aside>
    </section>
@endsection
