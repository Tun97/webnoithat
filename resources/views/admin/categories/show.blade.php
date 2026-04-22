@extends('admin.layouts.app')

@section('admin_page', 'categories-show')
@section('title', 'Chi tiết danh mục')
@section('eyebrow', 'Categories')
@section('description', 'Xem nhanh toàn bộ thông tin quan trọng của danh mục trước khi thực hiện chỉnh sửa hoặc xóa.')

@section('actions')
    <a href="{{ route('admin.categories.edit', $category) }}" class="btn">Chỉnh sửa</a>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Quay lại</a>
@endsection

@section('content')
    <section class="detail-shell">
        <article class="surface-panel detail-panel">
            <div class="detail-list">
                <div class="detail-item">
                    <span>ID</span>
                    <strong>#{{ $category->id }}</strong>
                </div>
                <div class="detail-item">
                    <span>Tên danh mục</span>
                    <strong>{{ $category->name }}</strong>
                </div>
                <div class="detail-item">
                    <span>Slug</span>
                    <strong>{{ $category->slug }}</strong>
                </div>
                <div class="detail-item">
                    <span>Mô tả</span>
                    <strong>{{ $category->description ?: 'Chưa có mô tả.' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Ngày tạo</span>
                    <strong>{{ optional($category->created_at)->format('d/m/Y H:i') }}</strong>
                </div>
                <div class="detail-item">
                    <span>Cập nhật gần nhất</span>
                    <strong>{{ optional($category->updated_at)->format('d/m/Y H:i') }}</strong>
                </div>
            </div>
        </article>
    </section>
@endsection
