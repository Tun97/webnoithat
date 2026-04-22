@extends('admin.layouts.app')

@section('admin_page', 'products-index')
@section('title', 'Sản phẩm')
@section('eyebrow', 'Products')
@section('description', 'Quản lý danh sách sản phẩm, kiểm soát tồn kho và rà soát nhanh thông tin giá, màu sắc, chất liệu.')

@section('actions')
    <a href="{{ route('admin.products.create') }}" class="btn">Thêm sản phẩm</a>
@endsection

@section('content')
    <section class="resource-toolbar">
        <div class="resource-toolbar__search">
            <label for="product-search">Tìm sản phẩm</label>
            <input id="product-search" type="search" placeholder="Nhập tên, slug, màu sắc..." data-filter-input="products">
        </div>
        <div class="resource-toolbar__meta">
            <span class="metric-pill">Hiển thị <strong data-filter-count="products">{{ $products->count() }}</strong> mục</span>
            <span class="metric-pill metric-pill--warning">Kho cần theo dõi</span>
        </div>
    </section>

    @if ($products->count())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Thuộc tính</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody data-filter-body="products">
                    @foreach ($products as $product)
                        <tr data-filter-row data-stock-value="{{ (int) $product->quantity }}">
                            <td>#{{ $product->id }}</td>
                            <td>
                                <strong>{{ $product->name }}</strong><br>
                                <span class="helper">{{ $product->slug }}</span>
                            </td>
                            <td>{{ $product->category?->name ?? 'Chưa gán danh mục' }}</td>
                            <td>{{ number_format((float) $product->price, 0, ',', '.') }} đ</td>
                            <td><span class="stock-pill">{{ number_format($product->quantity) }}</span></td>
                            <td>
                                Chất liệu: {{ $product->material ?: 'Chưa có' }}<br>
                                Màu sắc: {{ $product->color ?: 'Chưa có' }}
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.products.show', $product) }}" class="btn btn-secondary">Xem</a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary">Sửa</a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-form" onsubmit="return confirm('Xóa sản phẩm này?');">
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

        <div class="empty-filter-state" data-filter-empty="products" hidden>
            <strong>Không tìm thấy sản phẩm phù hợp</strong>
            <p>Thử tìm theo tên ngắn hơn, màu sắc hoặc slug của sản phẩm.</p>
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>
    @else
        <div class="empty-state">
            <strong>Chưa có sản phẩm nào</strong>
            <p>Hãy thêm sản phẩm đầu tiên để khởi tạo khu vực quản trị kho hàng.</p>
        </div>
    @endif
@endsection
