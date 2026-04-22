<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Category;
use Illuminate\View\View;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalCategories = Category::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalOrders = Order::count();
        $totalContacts = Contact::count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $revenueChart = $this->buildRevenueChart();
        $orderStatusChart = $this->buildOrderStatusChart();
        $topProductChart = $this->buildTopProductChart();

        return view('admin.dashboard.index', compact(
            'totalCategories',
            'totalProducts',
            'totalCustomers',
            'totalOrders',
            'totalContacts',
            'totalRevenue',
            'revenueChart',
            'orderStatusChart',
            'topProductChart'
        ));
    }

    private function buildRevenueChart(): Collection
    {
        $months = collect(range(5, 0))
            ->map(fn (int $monthsAgo) => now()->startOfMonth()->subMonths($monthsAgo));

        $orders = Order::query()
            ->where('payment_status', 'paid')
            ->where('created_at', '>=', $months->first())
            ->get(['total_amount', 'created_at']);

        $points = $months->map(function ($month) use ($orders) {
            $value = $orders
                ->filter(fn (Order $order) => $order->created_at?->isSameMonth($month))
                ->sum('total_amount');

            return [
                'label' => $month->format('m/Y'),
                'value' => (float) $value,
            ];
        });

        $maxValue = max((float) $points->max('value'), 1);

        return $points->map(fn (array $point) => [
            ...$point,
            'percentage' => max(6, round(($point['value'] / $maxValue) * 100, 1)),
        ]);
    }

    private function buildOrderStatusChart(): Collection
    {
        $statusCounts = Order::query()
            ->selectRaw('order_status, COUNT(*) as aggregate')
            ->groupBy('order_status')
            ->pluck('aggregate', 'order_status');

        $total = max((int) $statusCounts->sum(), 1);

        return collect(Order::STATUS_LABELS)->map(function (string $label, string $status) use ($statusCounts, $total) {
            $count = (int) ($statusCounts[$status] ?? 0);

            return [
                'status' => $status,
                'label' => $label,
                'count' => $count,
                'percentage' => max($count > 0 ? 8 : 0, round(($count / $total) * 100, 1)),
            ];
        })->values();
    }

    private function buildTopProductChart(): Collection
    {
        $products = OrderItem::query()
            ->select('product_name')
            ->selectRaw('SUM(quantity) as sold_quantity')
            ->selectRaw('SUM(subtotal) as sold_amount')
            ->whereHas('order', fn ($query) => $query->where('order_status', '!=', 'cancelled'))
            ->groupBy('product_name')
            ->orderByDesc('sold_quantity')
            ->take(6)
            ->get();

        $maxQuantity = max((int) $products->max('sold_quantity'), 1);

        return $products->map(fn (OrderItem $item) => [
            'name' => $item->product_name,
            'quantity' => (int) $item->sold_quantity,
            'amount' => (float) $item->sold_amount,
            'percentage' => max(8, round(((int) $item->sold_quantity / $maxQuantity) * 100, 1)),
        ]);
    }
}
