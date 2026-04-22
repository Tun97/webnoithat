@extends('admin.layouts.app')

@section('admin_page', 'banners-create')
@section('title', 'Thêm banner')
@section('eyebrow', 'Banners')
@section('description', 'Tạo banner mới với tiêu đề rõ ràng và xem trước hình ảnh trước khi lưu.')

@section('actions')
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
@endsection

@section('content')
    <section class="surface-grid surface-grid--form">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="surface-panel">
            @csrf

            <div class="form-grid">
                <div class="field">
                    <label for="title">Tiêu đề banner</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required data-title-preview-source>
                    @error('title')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="image">Hình ảnh</label>
                    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp" required data-image-input>
                    <div class="helper">Tải lên ảnh JPG, PNG hoặc WEBP tối đa 2MB.</div>
                    @error('image')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Lưu banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>

        <aside class="surface-panel form-aside" data-image-preview-wrapper>
            <div class="panel-kicker">Xem trước</div>
            <h2 data-title-preview>{{ old('title') ?: 'Tiêu đề banner' }}</h2>
            <div class="image-preview-shell image-preview-shell--banner">
                <img src="" alt="Xem trước banner" class="image-preview" data-image-preview hidden>
                <div class="image-placeholder" data-image-placeholder>Chưa chọn ảnh banner</div>
            </div>
        </aside>
    </section>
@endsection
