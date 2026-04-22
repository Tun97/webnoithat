<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;

class OrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('user')->latest()->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('user', 'orderItems.product', 'statusHistories.changedBy');

        return view('admin.orders.show', compact('order'));
    }

    public function update(UpdateOrderStatusRequest $request, Order $order): RedirectResponse
    {
        $previousStatus = $order->order_status;

        $order->update([
            'order_status' => $request->order_status,
        ]);

        if ($previousStatus !== $request->order_status) {
            $order->statusHistories()->create([
                'status' => $request->order_status,
                'label' => Order::STATUS_LABELS[$request->order_status] ?? $request->order_status,
                'note' => match ($request->order_status) {
                    'shipping' => 'Đơn hàng đã được bàn giao cho đơn vị vận chuyển.',
                    'completed' => 'Đơn hàng đã giao thành công cho khách hàng.',
                    'cancelled' => 'Đơn hàng đã bị hủy.',
                    default => 'Trạng thái đơn hàng vừa được cập nhật.',
                },
                'changed_by' => auth()->id(),
            ]);
        }

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Cập nhật trạng thái đơn hàng thành công.');
    }
}
