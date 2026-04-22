@extends('admin.layouts.app')

@section('admin_page', 'banners-edit')
@section('title', 'Sửa banner')
@section('eyebrow', 'Banners')
@section('description', 'Cập nhật tiêu đề, thay đổi ảnh hiển thị và xem trước nội dung banner trong cùng một khu vực.')

@section('actions')
    <a href="{{ route('admin.banners.show', $banner) }}" class="btn btn-secondary">Xem chi tiết</a>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection

@section('content')
    <section class="surface-grid surface-grid--form">
        <form action="{{ route('admin.banners.update', $banner) }}" method="POST" enctype="multipart/form-data" class="surface-panel">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="field">
                    <label for="title">Tiêu đề banner</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $banner->title) }}" required data-title-preview-source>
                    @error('title')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="field">
                    <label for="image">Đổi hình ảnh</label>
                    <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png,.webp" data-image-input>
                    <div class="helper">Bạn có thể giữ nguyên ảnh hiện tại nếu không cần cập nhật.</div>
                    @error('image')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn">Cập nhật banner</button>
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Hủy</a>
            </div>
        </form>

        <aside class="surface-panel form-aside" data-image-preview-wrapper>
            <div class="panel-kicker">Xem trước</div>
            <h2 data-title-preview>{{ old('title', $banner->title) }}</h2>
            <div class="image-preview-shell image-preview-shell--banner">
                @if ($banner->image)
                    <img src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}" class="image-preview" data-image-preview data-default-src="{{ asset('storage/' . $banner->image) }}">
                    <div class="image-placeholder" data-image-placeholder hidden>Chưa chọn ảnh banner</div>
                @else
                    <img src="" alt="Xem trước banner" class="image-preview" data-image-preview hidden>
                    <div class="image-placeholder" data-image-placeholder>Chưa có ảnh hiện tại</div>
                @endif
            </div>
        </aside>
    </section>
@endsection
