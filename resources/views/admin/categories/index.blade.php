@extends('admin.layouts.app')

@section('admin_page', 'categories-index')
@section('title', 'Danh mục')
@section('eyebrow', 'Categories')
@section('description', 'Sắp xếp cấu trúc danh mục, rà soát slug và quản lý nội dung mô tả theo từng nhóm sản phẩm.')

@section('actions')
    <a href="{{ route('admin.categories.create') }}" class="btn">Thêm danh mục</a>
@endsection

@section('content')
    <section class="resource-toolbar">
        <div class="resource-toolbar__search">
            <label for="category-search">Tìm danh mục</label>
            <input id="category-search" type="search" placeholder="Nhập tên hoặc slug..." data-filter-input="categories">
        </div>
        <div class="resource-toolbar__meta">
            <span class="metric-pill">Hiển thị <strong data-filter-count="categories">{{ $categories->count() }}</strong> mục</span>
            <span class="metric-pill metric-pill--soft">Phân loại sản phẩm</span>
        </div>
    </section>

    @if ($categories->count())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th>Mô tả</th>
                        <th>Tạo lúc</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody data-filter-body="categories">
                    @foreach ($categories as $category)
                        <tr data-filter-row>
                            <td>#{{ $category->id }}</td>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->description ?: 'Chưa có mô tả.' }}</td>
                            <td>{{ optional($category->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-secondary">Xem</a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-secondary">Sửa</a>
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-form" onsubmit="return confirm('Xóa danh mục này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="empty-filter-state" data-filter-empty="categories" hidden>
            <strong>Không tìm thấy danh mục phù hợp</strong>
            <p>Thử lại với từ khóa ngắn hơn hoặc kiểm tra cách viết slug.</p>
        </div>

        <div class="pagination">
            {{ $categories->links() }}
        </div>
    @else
        <div class="empty-state">
            <strong>Chưa có danh mục nào</strong>
            <p>Hãy tạo danh mục đầu tiên để bắt đầu xây dựng cấu trúc nội dung.</p>
        </div>
    @endif
@endsection
