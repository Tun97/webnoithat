@extends('admin.layouts.app')

@section('admin_page', 'categories-edit')
@section('title', 'Sửa danh mục')
@section('eyebrow', 'Categories')
@section('description', 'Điều chỉnh tên, slug và mô tả của danh mục hiện có mà vẫn giữ trải nghiệm quản trị rõ ràng.')

@section('actions')
    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-secondary">Xem chi tiết</a>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection

@section('content')
    <section class="surface-grid surface-grid--form">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="surface-panel" data-slug-form>
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="field">
                    <label for="name">Tên danh mục</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required data-slug-source>
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="slug">Slug</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" required data-slug-target>
                    @error('slug')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field field-full">
                    <label for="description">Mô tả</label>
                    <textarea id="description" name="description" data-autosize>{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Cập nhật</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>

        <aside class="surface-panel form-aside">
            <div class="panel-kicker">Thông tin hiện tại</div>
            <h2>{{ $category->name }}</h2>
            <div class="preview-tile">
                <span>Slug hiện tại</span>
                <strong data-slug-preview>{{ old('slug', $category->slug) }}</strong>
            </div>
            <p>Cập nhật slug khi thật sự cần thiết để tránh thay đổi liên kết không mong muốn.</p>
        </aside>
    </section>
@endsection
