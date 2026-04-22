@extends('admin.layouts.app')

@section('admin_page', 'banners-show')
@section('title', 'Chi tiết banner')
@section('eyebrow', 'Banners')
@section('description', 'Kiểm tra tiêu đề và ảnh banner đang được lưu trước khi quyết định thay đổi.')

@section('actions')
    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn">Chỉnh sửa</a>
    <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection

@section('content')
    <section class="surface-grid surface-grid--detail">
        <article class="surface-panel detail-panel">
            <div class="detail-list">
                <div class="detail-item">
                    <span>ID</span>
                    <strong>#{{ $banner->id }}</strong>
                </div>
                <div class="detail-item">
                    <span>Tiêu đề</span>
                    <strong>{{ $banner->title }}</strong>
                </div>
                <div class="detail-item">
                    <span>Ngày tạo</span>
                    <strong>{{ optional($banner->created_at)->format('d/m/Y H:i') }}</strong>
                </div>
                <div class="detail-item">
                    <span>Cập nhật gần nhất</span>
                    <strong>{{ optional($banner->updated_at)->format('d/m/Y H:i') }}</strong>
                </div>
            </div>
        </article>

        <article class="surface-panel media-panel">
            <div class="panel-kicker">Hình ảnh banner</div>
            <h2>{{ $banner->title }}</h2>
            @if ($banner->image)
                <img class="thumb thumb--wide" src="{{ asset('storage/' . $banner->image) }}" alt="{{ $banner->title }}">
            @else
                <div class="empty-state">
                    <strong>Banner chưa có ảnh</strong>
                    <p>Hãy cập nhật để đảm bảo khu vực quảng bá hiển thị đầy đủ.</p>
                </div>
            @endif
        </article>
    </section>
@endsection
