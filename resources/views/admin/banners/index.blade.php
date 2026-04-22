@extends('admin.layouts.app')

@section('admin_page', 'banners-index')
@section('title', 'Banner')
@section('eyebrow', 'Banners')
@section('description', 'Quản lý nội dung banner và kiểm soát chất lượng hiển thị của các hình ảnh nổi bật trên giao diện người dùng.')

@section('actions')
    <a href="{{ route('admin.banners.create') }}" class="btn">Thêm banner</a>
@endsection

@section('content')
    <section class="resource-toolbar">
        <div class="resource-toolbar__search">
            <label for="banner-search">Tìm banner</label>
            <input id="banner-search" type="search" placeholder="Nhập tiêu đề banner..." data-filter-input="banners">
        </div>
        <div class="resource-toolbar__meta">
            <span class="metric-pill">Hiển thị <strong data-filter-count="banners">{{ $banners->count() }}</strong> mục</span>
            <span class="metric-pill metric-pill--soft">Khu vực quảng bá</span>
        </div>
    </section>

    @if ($banners->count())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề</th>
                        <th>Hình ảnh</th>
                        <th>Tạo lúc</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody data-filter-body="banners">
                    @foreach ($banners as $banner)
                        <tr data-filter-row>
                            <td>#{{ $banner->id }}</td>
                            <td><strong>{{ $banner->title }}</strong></td>
                            <td>
                                @if ($banner->image)
                                    <span class="badge">Đã có ảnh</span>
                                @else
                                    <span class="badge">Chưa có ảnh</span>
                                @endif
                            </td>
                            <td>{{ optional($banner->created_at)->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.banners.show', $banner) }}" class="btn btn-secondary">Xem</a>
                                    <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-secondary">Sửa</a>
                                    <form action="{{ route('admin.banners.destroy', $banner) }}" method="POST" class="inline-form" onsubmit="return confirm('Xóa banner này?');">
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

        <div class="empty-filter-state" data-filter-empty="banners" hidden>
            <strong>Không tìm thấy banner phù hợp</strong>
            <p>Thử tìm lại bằng một phần tiêu đề hoặc kiểm tra chính tả.</p>
        </div>

        <div class="pagination">
            {{ $banners->links() }}
        </div>
    @else
        <div class="empty-state">
            <strong>Chưa có banner nào</strong>
            <p>Hãy thêm banner để làm mới khu vực truyền thông của cửa hàng.</p>
        </div>
    @endif
@endsection
