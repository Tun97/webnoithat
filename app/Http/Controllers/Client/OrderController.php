<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Services\VietQrService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display the authenticated customer's order history.
     */
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->with(['orderItems', 'statusHistories'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(8);

        return view('client.orders.index', [
            'catalogCategories' => $this->catalogCategories(),
            'orders' => $orders,
            'statusLabels' => Order::STATUS_LABELS,
        ]);
    }

    /**
     * Display a single order that belongs to the authenticated customer.
     */
    public function show(Request $request, Order $order, VietQrService $vietQr): View
    {
        abort_unless((int) $order->user_id === (int) $request->user()->id, 404);

        $order->load([
            'orderItems.product',
            'statusHistories.changedBy',
        ]);

        return view('client.orders.show', [
            'catalogCategories' => $this->catalogCategories(),
            'order' => $order,
            'bankTransfer' => $vietQr->forOrder($order),
            'statusLabels' => Order::STATUS_LABELS,
        ]);
    }

    public function confirmBankTransfer(Request $request, Order $order): RedirectResponse
    {
        abort_unless((int) $order->user_id === (int) $request->user()->id, 404);
        abort_unless($order->payment_method === 'bank_transfer', 404);

        if ($order->isPaid()) {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('status', 'Đơn hàng này đã được xác nhận thanh toán.');
        }

        $validated = $request->validate([
            'payment_bill' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ], [
            'payment_bill.required' => 'Vui lòng tải lên bill chuyển khoản.',
            'payment_bill.mimes' => 'Bill chuyển khoản phải là ảnh JPG, PNG, WEBP hoặc file PDF.',
            'payment_bill.max' => 'Bill chuyển khoản không được vượt quá 5MB.',
        ]);

        if ($order->bank_transfer_receipt_path) {
            Storage::disk('public')->delete($order->bank_transfer_receipt_path);
        }

        $file = $validated['payment_bill'];
        $path = $file->store('bank-transfer-bills', 'public');
        $previousOrderStatus = $order->order_status;

        $order->forceFill([
            'payment_status' => 'paid',
            'paid_at' => $order->paid_at ?: now(),
            'bank_transfer_receipt_path' => $path,
            'bank_transfer_receipt_original_name' => $file->getClientOriginalName(),
            'bank_transfer_receipt_uploaded_at' => now(),
            'order_status' => 'shipping',
        ])->save();

        $order->statusHistories()->create([
            'status' => 'payment_paid',
            'label' => 'Đã thanh toán chuyển khoản',
            'note' => 'Khách hàng đã xác nhận chuyển khoản và tải lên bill thanh toán.',
            'changed_by' => $request->user()->id,
        ]);

        if ($previousOrderStatus !== 'shipping') {
            $order->statusHistories()->create([
                'status' => 'shipping',
                'label' => Order::STATUS_LABELS['shipping'],
                'note' => 'Đơn hàng đã có bill chuyển khoản và được chuyển sang trạng thái đang giao.',
                'changed_by' => $request->user()->id,
            ]);
        }

        return redirect()
            ->route('client.orders.show', $order)
            ->with('status', 'Đã nhận bill chuyển khoản và xác nhận thanh toán thành công.');
    }

    /**
     * Fetch categories shown in the client header.
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, \App\Models\Category>
     */
    protected function catalogCategories()
    {
        return Category::query()
            ->whereHas('products')
            ->withCount('products')
            ->latest()
            ->take(8)
            ->get();
    }
}
