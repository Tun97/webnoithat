@extends('admin.layouts.app')

@section('admin_page', 'orders-show')
@section('title', 'Chi tiết đơn hàng')
@section('eyebrow', 'Orders')
@section('description', 'Xem thông tin giao nhận, sản phẩm trong đơn và cập nhật trạng thái xử lý trực tiếp tại cùng một màn hình.')

@section('actions')
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
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
        <div class="stack">
            <article class="surface-panel detail-panel">
                <div class="detail-list">
                    <div class="detail-item">
                        <span>Mã đơn</span>
                        <strong>#{{ $order->id }}</strong>
                    </div>
                    <div class="detail-item">
                        <span>Khách hàng</span>
                        <strong>{{ $order->customer_name }}</strong>
                    </div>
                    <div class="detail-item">
                        <span>Số điện thoại</span>
                        <strong>{{ $order->phone }}</strong>
                    </div>
                    <div class="detail-item">
                        <span>Địa chỉ</span>
                        <strong>{{ $order->address }}</strong>
                    </div>
                    <div class="detail-item">
                        <span>Ghi chú</span>
                        <strong>{{ $order->note ?: 'Không có ghi chú.' }}</strong>
                    </div>
                    <div class="detail-item">
                        <span>Thanh toán</span>
                        <strong>{{ $order->paymentMethodLabel() }} - {{ $order->paymentStatusLabel() }}</strong>
                    </div>
                    @if ($order->bank_transfer_receipt_path)
                        <div class="detail-item">
                            <span>Bill chuyển khoản</span>
                            <strong>
                                <a href="{{ asset('storage/'.$order->bank_transfer_receipt_path) }}" target="_blank" rel="noopener">
                                    {{ $order->bank_transfer_receipt_original_name ?: 'Xem bill thanh toán' }}
                                </a>
                            </strong>
                        </div>
                    @endif
                    <div class="detail-item">
                        <span>Tổng tiền</span>
                        <strong>{{ number_format((float) $order->total_amount, 0, ',', '.') }} đ</strong>
                    </div>
                </div>
            </article>

            <article class="surface-panel status-panel" data-status-form>
                <div class="panel-kicker">Điều phối đơn hàng</div>
                <h2>Cập nhật trạng thái</h2>
                <div class="status-preview">
                    <span>Trạng thái hiện tại</span>
                    <strong class="badge status-{{ $order->order_status }}" data-status-display>{{ $statusLabels[$order->order_status] ?? $order->order_status }}</strong>
                </div>
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="stack">
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label for="order_status">Trạng thái đơn hàng</label>
                        <select id="order_status" name="order_status" required data-status-select>
                            @foreach ($statusLabels as $value => $label)
                                <option value="{{ $value }}" @selected(old('order_status', $order->order_status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('order_status')
                            <div class="field-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="actions">
                        <button type="submit" class="btn">Lưu trạng thái</button>
                    </div>
                </form>
            </article>
        </div>

        <article class="surface-panel">
            <div class="panel-kicker">Mặt hàng trong đơn</div>
            <h2>Chi tiết sản phẩm</h2>
            @if ($order->orderItems->count())
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->orderItems as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product_name }}</strong><br>
                                        <span class="helper">{{ $item->product?->name ? 'Liên kết sản phẩm còn tồn tại' : 'Sản phẩm gốc có thể đã thay đổi' }}</span>
                                    </td>
                                    <td>{{ number_format((float) $item->price, 0, ',', '.') }} đ</td>
                                    <td>{{ number_format($item->quantity) }}</td>
                                    <td>{{ number_format((float) $item->subtotal, 0, ',', '.') }} đ</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <strong>Không có mặt hàng trong đơn</strong>
                    <p>Dữ liệu mặt hàng chưa được ghi nhận hoặc đang thiếu liên kết.</p>
                </div>
            @endif
        </article>
    </section>
@endsection
