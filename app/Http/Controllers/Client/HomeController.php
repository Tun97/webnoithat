<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the client home page.
     */
    public function index(): View
    {
        $catalogCategories = Category::query()
            ->withCount('products')
            ->latest()
            ->get();

        $banners = Banner::query()
            ->latest()
            ->take(4)
            ->get()
            ->values();

        $sectionCategories = Category::query()
            ->whereHas('products')
            ->with([
                'products' => fn ($query) => $query->latest(),
            ])
            ->latest()
            ->get();

        $sections = $sectionCategories
            ->values()
            ->map(function (Category $category, int $index) use ($banners): ?array {
                $products = $category->products
                    ->take(6)
                    ->values();

                if ($products->isEmpty()) {
                    return null;
                }

                $sideLeft = $products->first();
                $sideRight = $products->get(1) ?? $sideLeft;
                $heroBanner = $banners->isNotEmpty()
                    ? $banners->get($index % $banners->count())
                    : null;

                return [
                    'title' => $category->name,
                    'links' => $products
                        ->take(6)
                        ->map(fn (Product $product) => Str::limit($product->name, 24, '...'))
                        ->values(),
                    'hero_title' => $category->name,
                    'hero_subtitle' => $heroBanner?->title
                        ? Str::limit($heroBanner->title, 42, '...')
                        : 'Thương hiệu nội thất hàng đầu Việt Nam',
                    'hero_image' => $heroBanner?->image
                        ? asset('storage/'.$heroBanner->image)
                        : $this->productImageUrl($sideRight),
                    'side_left' => $this->mapProductCard($sideLeft),
                    'side_right' => $this->mapProductCard($sideRight),
                    'products' => $products
                        ->slice(2)
                        ->take(4)
                        ->map(fn (Product $product) => $this->mapProductCard($product))
                        ->values(),
                ];
            })
            ->filter()
            ->values();

        return view('client.home.index', [
            'catalogCategories' => $catalogCategories,
            'sections' => $sections,
        ]);
    }

    /**
     * Map a product into the card structure used on the home page.
     *
     * @return array<string, string|null>
     */
    protected function mapProductCard(Product $product): array
    {
        return [
            'title' => $product->name,
            'price' => (float) $product->price > 0
                ? number_format((float) $product->price, 0, ',', '.').' đ'
                : 'Liên hệ',
            'image' => $this->productImageUrl($product),
            'url' => route('client.products.show', $product),
        ];
    }

    protected function productImageUrl(Product $product): string
    {
        return filled($product->image)
            ? asset('storage/'.$product->image)
            : asset('images/baner1.jpg');
    }
}
