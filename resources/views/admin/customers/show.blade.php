@extends('admin.layouts.app')

@section('admin_page', 'customers-show')
@section('title', 'Chi tiết khách hàng')
@section('eyebrow', 'Customers')
@section('description', 'Xem hồ sơ khách hàng và toàn bộ lịch sử đơn hàng liên quan trong một bố cục gọn gàng.')

@section('actions')
    <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
@endsection

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Chờ xử lý',
            'shipping' => 'Đang giao',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
        ];
    @endphp

    <section class="surface-grid surface-grid--detail">
        <article class="surface-panel detail-panel">
            <div class="detail-list">
                <div class="detail-item">
                    <span>ID</span>
                    <strong>#{{ $user->id }}</strong>
                </div>
                <div class="detail-item">
                    <span>Họ tên</span>
                    <strong>{{ $user->name }}</strong>
                </div>
                <div class="detail-item">
                    <span>Email</span>
                    <strong>{{ $user->email }}</strong>
                </div>
                <div class="detail-item">
                    <span>Số điện thoại</span>
                    <strong>{{ $user->phone ?: 'Chưa cập nhật' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Địa chỉ</span>
                    <strong>{{ $user->address ?: 'Chưa cập nhật' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Vai trò</span>
                    <strong>{{ $user->role }}</strong>
                </div>
                <div class="detail-item">
                    <span>Ngày tạo tài khoản</span>
                    <strong>{{ optional($user->created_at)->format('d/m/Y H:i') }}</strong>
                </div>
            </div>
        </article>

        <article class="surface-panel">
            <div class="panel-kicker">Lịch sử giao dịch</div>
            <h2>Đơn hàng của khách</h2>
            @if ($user->orders->count())
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->orders as $order)
                                <tr>
                                    <td><a href="{{ route('admin.orders.show', $order) }}"><strong>#{{ $order->id }}</strong></a></td>
                                    <td>{{ number_format((float) $order->total_amount, 0, ',', '.') }} đ</td>
                                    <td>
                                        <span class="badge status-{{ $order->order_status }}">
                                            {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                                        </span>
                                    </td>
                                    <td>{{ optional($order->created_at)->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <strong>Khách hàng chưa có đơn hàng</strong>
                    <p>Khi phát sinh giao dịch, dữ liệu sẽ hiển thị ngay tại khu vực này.</p>
                </div>
            @endif
        </article>
    </section>
@endsection
