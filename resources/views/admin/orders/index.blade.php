@extends('admin.layouts.app')

@section('admin_page', 'orders-index')
@section('title', 'Đơn hàng')
@section('eyebrow', 'Orders')
@section('description', 'Theo dõi đơn hàng theo trạng thái, tra cứu nhanh thông tin khách mua và tổng tiền của từng đơn.')

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Chờ xử lý',
            'shipping' => 'Đang giao',
            'completed' => 'Hoàn tất',
            'cancelled' => 'Đã hủy',
        ];
    @endphp

    <section class="resource-toolbar">
        <div class="resource-toolbar__search">
            <label for="order-search">Tìm đơn hàng</label>
            <input id="order-search" type="search" placeholder="Nhập tên khách, địa chỉ, mã đơn..." data-filter-input="orders">
        </div>
        <div class="resource-toolbar__meta resource-toolbar__meta--wrap">
            <span class="metric-pill">Hiển thị <strong data-filter-count="orders">{{ $orders->count() }}</strong> đơn</span>
            <div class="status-filter-group">
                <button type="button" class="status-filter is-active" data-status-filter="all">Tất cả</button>
                <button type="button" class="status-filter" data-status-filter="pending">Chờ xử lý</button>
                <button type="button" class="status-filter" data-status-filter="shipping">Đang giao</button>
                <button type="button" class="status-filter" data-status-filter="completed">Hoàn tất</button>
                <button type="button" class="status-filter" data-status-filter="cancelled">Đã hủy</button>
            </div>
        </div>
    </section>

    @if ($orders->count())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Liên hệ</th>
                        <th>Thanh toán</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody data-filter-body="orders">
                    @foreach ($orders as $order)
                        <tr data-filter-row data-order-status="{{ $order->order_status }}">
                            <td>#{{ $order->id }}</td>
                            <td>
                                <strong>{{ $order->customer_name }}</strong><br>
                                <span class="helper">{{ $order->user?->email ?? 'Không có email' }}</span>
                            </td>
                            <td>
                                {{ $order->phone }}<br>
                                <span class="helper">{{ $order->address }}</span>
                            </td>
                            <td>
                                {{ $order->paymentMethodLabel() }}<br>
                                <span class="helper">{{ $order->paymentStatusLabel() }}</span>
                            </td>
                            <td>{{ number_format((float) $order->total_amount, 0, ',', '.') }} đ</td>
                            <td>
                                <span class="badge status-{{ $order->order_status }}">
                                    {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">Xem</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="empty-filter-state" data-filter-empty="orders" hidden>
            <strong>Không tìm thấy đơn hàng phù hợp</strong>
            <p>Hãy thử từ khóa khác hoặc bỏ bộ lọc trạng thái đang chọn.</p>
        </div>

        <div class="pagination">
            {{ $orders->links() }}
        </div>
    @else
        <div class="empty-state">
            <strong>Chưa có đơn hàng</strong>
            <p>Danh sách đơn hàng sẽ hiển thị tại đây khi khách bắt đầu mua sắm.</p>
        </div>
    @endif
@endsection
