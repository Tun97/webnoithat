<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Display the authenticated customer's cart.
     */
    public function index(Request $request): View
    {
        $cart = $this->resolveCart($request);
        $cart->load('cartItems.product.category');

        $cartItems = $cart->cartItems
            ->filter(fn (CartItem $item) => $item->product !== null)
            ->values();

        return view('client.cart.index', [
            'catalogCategories' => $this->catalogCategories(),
            'cartItems' => $cartItems,
            'subtotal' => $cartItems->sum(fn (CartItem $item) => $item->quantity * (float) $item->price),
        ]);
    }

    /**
     * Add a product to the authenticated customer's cart.
     */
    public function store(Request $request, Product $product): RedirectResponse
    {
        if ($product->quantity < 1) {
            throw ValidationException::withMessages([
                'product' => 'Sản phẩm này hiện đã hết hàng.',
            ]);
        }

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1'],
        ], [
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
        ]);

        $cart = $this->resolveCart($request);
        $quantity = (int) ($validated['quantity'] ?? 1);

        $cartItem = $cart->cartItems()->firstOrNew([
            'product_id' => $product->id,
        ]);

        $nextQuantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;

        if ($nextQuantity > $product->quantity) {
            throw ValidationException::withMessages([
                'product' => 'Số lượng thêm vào giỏ vượt quá tồn kho hiện có.',
            ]);
        }

        $cartItem->fill([
            'quantity' => $nextQuantity,
            'price' => $product->price,
        ])->save();

        return redirect()
            ->route('client.cart.index')
            ->with('status', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    /**
     * Update a cart item quantity.
     */
    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->ensureOwnedByCurrentUser($request, $cartItem);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ], [
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Số lượng phải là số nguyên.',
            'quantity.min' => 'Số lượng phải lớn hơn 0.',
        ]);

        $product = $cartItem->product;

        if (! $product) {
            $cartItem->delete();

            return redirect()
                ->route('client.cart.index')
                ->with('status', 'Sản phẩm không còn tồn tại nên đã được xóa khỏi giỏ hàng.');
        }

        if ((int) $validated['quantity'] > $product->quantity) {
            throw ValidationException::withMessages([
                'quantity' => 'Số lượng cập nhật vượt quá tồn kho hiện có.',
            ]);
        }

        $cartItem->update([
            'quantity' => (int) $validated['quantity'],
            'price' => $product->price,
        ]);

        return redirect()
            ->route('client.cart.index')
            ->with('status', 'Đã cập nhật giỏ hàng.');
    }

    /**
     * Remove a cart item.
     */
    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        $this->ensureOwnedByCurrentUser($request, $cartItem);
        $cartItem->delete();

        return redirect()
            ->route('client.cart.index')
            ->with('status', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    /**
     * Resolve the active user's cart.
     */
    protected function resolveCart(Request $request): Cart
    {
        return Cart::query()->firstOrCreate([
            'user_id' => $request->user()->id,
        ]);
    }

    /**
     * Ensure the cart item belongs to the signed-in customer.
     */
    protected function ensureOwnedByCurrentUser(Request $request, CartItem $cartItem): void
    {
        abort_unless((int) $cartItem->cart?->user_id === (int) $request->user()->id, 404);
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
