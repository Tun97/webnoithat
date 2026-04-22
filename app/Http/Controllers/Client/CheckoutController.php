<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Services\MomoPaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $user = $request->user();
        $cart = $this->resolveCart($request);
        $cart->load('cartItems.product.category');

        $cartItems = $cart->cartItems
            ->filter(fn($item) => $item->product !== null)
            ->values();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('client.cart.index')
                ->with('status', 'Giỏ hàng của bạn đang trống.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->quantity * (float) $item->price);
        $shippingFee = 30000;

        return view('client.checkout.index', [
            'catalogCategories' => $this->catalogCategories(),
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shippingFee' => $shippingFee,
            'total' => $subtotal + $shippingFee,
            'user' => $user,
        ]);
    }

    /**
     * Store a new order from the current cart.
     */
    public function store(Request $request, MomoPaymentService $momo): RedirectResponse
    {
        $user = $request->user();
        $cart = $this->resolveCart($request);
        $cart->load('cartItems.product');

        $cartItems = $cart->cartItems
            ->filter(fn($item) => $item->product !== null)
            ->values();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('client.cart.index')
                ->with('status', 'Giỏ hàng của bạn đang trống.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'address_line' => ['required', 'string', 'max:1000'],
            'province_id' => ['required', 'integer'],
            'province_name' => ['required', 'string', 'max:255'],
            'district_id' => ['required', 'integer'],
            'district_name' => ['required', 'string', 'max:255'],
            'ward_code' => ['required', 'string', 'max:32'],
            'ward_name' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'string', 'in:cod,bank_transfer,momo'],
            'note' => ['nullable', 'string', 'max:2000'],
        ], [
            'customer_name.required' => 'Vui lòng nhập tên người nhận.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'address_line.required' => 'Vui lòng nhập địa chỉ chi tiết.',
            'province_id.required' => 'Vui lòng chọn tỉnh / thành phố.',
            'district_id.required' => 'Vui lòng chọn quận / huyện.',
            'ward_code.required' => 'Vui lòng chọn phường / xã.',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán.',
        ]);

        $subtotal = $cartItems->sum(fn($item) => $item->quantity * (float) $item->price);
        $shippingFee = 30000;
        $fullAddress = $this->formatAddress($validated);

        $order = DB::transaction(function () use ($cart, $cartItems, $fullAddress, $shippingFee, $subtotal, $user, $validated) {
            foreach ($cartItems as $item) {
                $product = Product::query()->lockForUpdate()->find($item->product_id);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'cart' => 'Một sản phẩm trong giỏ hàng không còn tồn tại.',
                    ]);
                }

                if ($product->quantity < $item->quantity) {
                    throw ValidationException::withMessages([
                        'cart' => 'Sản phẩm "' . $product->name . '" không còn đủ số lượng trong kho.',
                    ]);
                }
            }

            $user->update([
                'name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'address' => $fullAddress,
                'address_line' => $validated['address_line'],
                'province_id' => (int) $validated['province_id'],
                'province_name' => $validated['province_name'],
                'district_id' => (int) $validated['district_id'],
                'district_name' => $validated['district_name'],
                'ward_code' => $validated['ward_code'],
                'ward_name' => $validated['ward_name'],
            ]);

            $order = Order::query()->create([
                'user_id' => $user->id,
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'address' => $fullAddress,
                'address_line' => $validated['address_line'],
                'province_id' => (int) $validated['province_id'],
                'province_name' => $validated['province_name'],
                'district_id' => (int) $validated['district_id'],
                'district_name' => $validated['district_name'],
                'ward_code' => $validated['ward_code'],
                'ward_name' => $validated['ward_name'],
                'note' => $validated['note'] ?? null,
                'total_amount' => $subtotal + $shippingFee,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
            ]);

            $order->statusHistories()->create([
                'status' => 'pending',
                'label' => Order::STATUS_LABELS['pending'],
                'note' => 'Đơn hàng đã được tạo và đang chờ cửa hàng xác nhận.',
                'changed_by' => $user->id,
            ]);

            foreach ($cartItems as $item) {
                $product = Product::query()->lockForUpdate()->findOrFail($item->product_id);

                $order->orderItems()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->quantity * (float) $item->price,
                ]);

                $product->decrement('quantity', $item->quantity);
            }

            $cart->cartItems()->delete();

            return $order;
        });

        if ($order->payment_method === 'momo') {
            return $this->startMomoPayment($order, $momo);
        }

        return redirect()
            ->route('client.orders.show', $order)
            ->with('status', 'Đặt hàng thành công. Bạn có thể theo dõi tiến độ xử lý ngay tại đây.');
    }

    public function momoRedirect(Request $request, Order $order, MomoPaymentService $momo): View|RedirectResponse
    {
        abort_unless((int) $order->user_id === (int) $request->user()->id, 404);
        abort_unless($order->payment_method === 'momo', 404);

        if ($order->isPaid()) {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('status', 'Đơn hàng này đã thanh toán MoMo thành công.');
        }

        if (! $order->momo_pay_url) {
            return $this->startMomoPayment($order, $momo);
        }

        return view('client.checkout.momo-redirect', [
            'catalogCategories' => $this->catalogCategories(),
            'order' => $order,
            'payUrl' => $order->momo_pay_url,
            'returnUrl' => route('client.checkout.momo.return', ['order_id' => $order->id]),
        ]);
    }

    public function momoReturn(Request $request, MomoPaymentService $momo): RedirectResponse
    {
        $order = $this->findMomoOrder($request);

        abort_unless($order, 404);
        abort_unless((int) $order->user_id === (int) $request->user()->id, 404);
        abort_unless($order->payment_method === 'momo', 404);

        $payload = $request->query();

        if ((bool) config('services.momo.complete_on_return')) {
            $this->markMomoOrderPaid($order, $payload, 'return');

            return redirect()
                ->route('client.orders.show', $order)
                ->with('status', 'Thanh toán MoMo đã được xác nhận tự động.');
        }

        if ((int) ($payload['resultCode'] ?? -1) === 0 && $momo->verifyCallback($payload)) {
            $this->markMomoOrderPaid($order, $payload, 'return');

            return redirect()
                ->route('client.orders.show', $order)
                ->with('status', 'Thanh toán MoMo thành công.');
        }

        $this->markMomoOrderFailed($order, $payload, 'return');

        return redirect()
            ->route('client.orders.show', $order)
            ->with('status', 'Thanh toán MoMo chưa hoàn tất.');
    }

    public function momoIpn(Request $request, MomoPaymentService $momo): JsonResponse
    {
        $payload = $request->all();

        if (! $momo->verifyCallback($payload)) {
            return response()->json(['message' => 'Invalid signature'], 400);
        }

        $order = Order::query()
            ->where('momo_order_id', $payload['orderId'] ?? null)
            ->first();

        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ((int) ($payload['resultCode'] ?? -1) === 0) {
            $this->markMomoOrderPaid($order, $payload, 'ipn');
        } else {
            $this->markMomoOrderFailed($order, $payload, 'ipn');
        }

        return response()->json(['message' => 'OK']);
    }

    protected function startMomoPayment(Order $order, MomoPaymentService $momo): RedirectResponse
    {
        try {
            $payment = $momo->createPayment(
                $order,
                route('client.checkout.momo.return', ['order_id' => $order->id]),
                route('client.checkout.momo.ipn')
            );

            $order->forceFill([
                'payment_status' => 'pending',
                'momo_order_id' => $payment['momo_order_id'],
                'momo_request_id' => $payment['momo_request_id'],
                'momo_pay_url' => $payment['payUrl'] ?? null,
                'momo_qr_code' => $payment['qrCodeUrl'] ?? null,
                'momo_response' => $payment,
            ])->save();

            return redirect()->route('client.checkout.momo.redirect', $order);
        } catch (Throwable $exception) {
            report($exception);

            $order->forceFill([
                'payment_status' => 'failed',
                'momo_response' => array_merge($order->momo_response ?? [], [
                    'create_error' => $exception->getMessage(),
                ]),
            ])->save();

            return redirect()
                ->route('client.orders.show', $order)
                ->with('status', 'Chưa mở được MoMo: ' . $exception->getMessage());
        }
    }

    protected function findMomoOrder(Request $request): ?Order
    {
        if ($request->filled('order_id')) {
            return Order::query()->find((int) $request->query('order_id'));
        }

        if ($request->filled('orderId')) {
            return Order::query()
                ->where('momo_order_id', $request->query('orderId'))
                ->first();
        }

        return null;
    }

    protected function markMomoOrderPaid(Order $order, array $payload, string $source): void
    {
        $alreadyPaid = $order->isPaid();
        $previousOrderStatus = $order->order_status;
        $nextOrderStatus = in_array($order->order_status, ['completed', 'cancelled'], true)
            ? $order->order_status
            : 'shipping';
        $response = $order->momo_response ?? [];
        $response[$source . '_payload'] = $payload;

        $order->forceFill([
            'payment_status' => 'paid',
            'paid_at' => $order->paid_at ?: now(),
            'momo_trans_id' => $payload['transId'] ?? $order->momo_trans_id,
            'momo_response' => $response,
            'order_status' => $nextOrderStatus,
        ])->save();

        if (! $alreadyPaid) {
            $order->statusHistories()->create([
                'status' => 'payment_paid',
                'label' => 'Đã thanh toán MoMo',
                'note' => $source === 'return'
                    ? 'Thanh toán MoMo sandbox được xác nhận tự động khi khách quay lại website.'
                    : 'MoMo xác nhận giao dịch thanh toán thành công.',
                'changed_by' => auth()->id(),
            ]);
        }

        if ($previousOrderStatus !== $nextOrderStatus && $nextOrderStatus === 'shipping') {
            $order->statusHistories()->create([
                'status' => 'shipping',
                'label' => Order::STATUS_LABELS['shipping'],
                'note' => 'Đơn hàng đã thanh toán MoMo thành công và được chuyển sang trạng thái đang giao.',
                'changed_by' => auth()->id(),
            ]);
        }
    }

    protected function markMomoOrderFailed(Order $order, array $payload, string $source): void
    {
        if ($order->isPaid()) {
            return;
        }

        $response = $order->momo_response ?? [];
        $response[$source . '_payload'] = $payload;

        $order->forceFill([
            'payment_status' => 'failed',
            'momo_response' => $response,
        ])->save();
    }

    /**
     * Resolve the authenticated user's cart.
     */
    protected function resolveCart(Request $request): Cart
    {
        return Cart::query()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);
    }

    /**
     * Build the full shipping address string.
     */
    protected function formatAddress(array $validated): string
    {
        return implode(', ', array_filter([
            $validated['address_line'] ?? null,
            $validated['ward_name'] ?? null,
            $validated['district_name'] ?? null,
            $validated['province_name'] ?? null,
        ]));
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
