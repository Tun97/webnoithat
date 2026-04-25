<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::with('category')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        $categories = Category::latest()->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = Arr::except($request->validated(), ['images']);

        $product = Product::create($data);
        $this->storeUploadedImages($product, $request->file('images', []));

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Thêm sản phẩm thành công.');
    }

    public function show(Product $product): View
    {
        $product->load('category', 'productImages');

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $product->load('productImages');
        $categories = Category::latest()->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = Arr::except($request->validated(), ['images']);

        $product->update($data);

        if ($request->hasFile('images')) {
            $this->replaceUploadedImages($product, $request->file('images', []));
        }

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->deleteStoredImages($product);

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Xóa sản phẩm thành công.');
    }

    private function replaceUploadedImages(Product $product, array $files): void
    {
        $this->deleteStoredImages($product);
        $this->storeUploadedImages($product, $files);
    }

    private function storeUploadedImages(Product $product, array $files): void
    {
        $paths = collect($files)
            ->filter()
            ->values()
            ->map(fn ($file) => $file->store('products', 'public'));

        if ($paths->isEmpty()) {
            return;
        }

        $product->forceFill(['image' => $paths->first()])->save();

        $paths->each(function (string $path) use ($product): void {
            $product->productImages()->create(['image' => $path]);
        });
    }

    private function deleteStoredImages(Product $product): void
    {
        $product->loadMissing('productImages');

        collect([$product->image])
            ->merge($product->productImages->pluck('image'))
            ->filter()
            ->unique()
            ->each(function (string $path): void {
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            });

        $product->productImages()->delete();
        $product->forceFill(['image' => null])->save();
        $product->unsetRelation('productImages');
    }
}
