@extends('admin.layouts.app')

@section('admin_page', 'customers-index')
@section('title', 'Khách hàng')
@section('eyebrow', 'Customers')
@section('description', 'Theo dõi hồ sơ khách hàng, dữ liệu liên hệ và truy cập nhanh vào lịch sử mua hàng của từng tài khoản.')

@section('content')
    <section class="resource-toolbar">
        <div class="resource-toolbar__search">
            <label for="customer-search">Tìm khách hàng</label>
            <input id="customer-search" type="search" placeholder="Nhập tên, email, số điện thoại..." data-filter-input="customers">
        </div>
        <div class="resource-toolbar__meta">
            <span class="metric-pill">Hiển thị <strong data-filter-count="customers">{{ $customers->count() }}</strong> mục</span>
            <span class="metric-pill metric-pill--soft">Tệp người mua</span>
        </div>
    </section>

    @if ($customers->count())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Liên hệ</th>
                        <th>Địa chỉ</th>
                        <th>Vai trò</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody data-filter-body="customers">
                    @foreach ($customers as $customer)
                        <tr data-filter-row>
                            <td>#{{ $customer->id }}</td>
                            <td>
                                <strong>{{ $customer->name }}</strong><br>
                                <span class="helper">{{ optional($customer->created_at)->format('d/m/Y H:i') }}</span>
                            </td>
                            <td>
                                {{ $customer->email }}<br>
                                <span class="helper">{{ $customer->phone ?: 'Chưa có số điện thoại' }}</span>
                            </td>
                            <td>{{ $customer->address ?: 'Chưa có địa chỉ' }}</td>
                            <td><span class="badge">{{ $customer->role }}</span></td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-secondary">Xem</a>
                                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="inline-form" onsubmit="return confirm('Xóa khách hàng này?');">
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

        <div class="empty-filter-state" data-filter-empty="customers" hidden>
            <strong>Không tìm thấy khách hàng phù hợp</strong>
            <p>Hãy thử tìm theo email, tên hoặc số điện thoại.</p>
        </div>

        <div class="pagination">
            {{ $customers->links() }}
        </div>
    @else
        <div class="empty-state">
            <strong>Chưa có khách hàng</strong>
            <p>Danh sách khách hàng sẽ xuất hiện tại đây khi có tài khoản đăng ký mới.</p>
        </div>
    @endif
@endsection
