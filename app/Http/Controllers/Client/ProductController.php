<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display the client product listing page.
     */
    public function index(Request $request): View
    {
        $catalogCategories = Category::query()
            ->whereHas('products')
            ->withCount('products')
            ->latest()
            ->take(8)
            ->get();

        $featuredCategories = Category::query()
            ->whereHas('products')
            ->withCount('products')
            ->latest()
            ->take(6)
            ->get();

        $selectedCategory = filled($request->string('category')->value())
            ? Category::query()->where('slug', $request->string('category')->value())->first()
            : null;

        $search = trim($request->string('q')->value());

        $baseProductQuery = Product::query()
            ->with('category')
            ->whereNotNull('image')
            ->where('image', '!=', '');

        if ($selectedCategory) {
            $baseProductQuery->where('category_id', $selectedCategory->id);
        }

        if ($search !== '') {
            $baseProductQuery->where(function ($query) use ($search): void {
                $query
                    ->where('name', 'like', '%'.$search.'%')
                    ->orWhere('material', 'like', '%'.$search.'%')
                    ->orWhere('color', 'like', '%'.$search.'%')
                    ->orWhere('description', 'like', '%'.$search.'%');
            });
        }

        $featuredProducts = (clone $baseProductQuery)
            ->latest()
            ->take(4)
            ->get()
            ->values();

        $products = (clone $baseProductQuery)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $products->setCollection(
            $products->getCollection()->values()->map(
                fn (Product $product, int $index): array => $this->mapProductCard($product, $index)
            )
        );

        $pageHeading = $selectedCategory?->name ?? 'Bộ sưu tập sản phẩm';
        $pageDescription = $search !== ''
            ? 'Kết quả tìm kiếm cho từ khóa "'.$search.'"'
            : 'Khám phá các mẫu nội thất được tuyển chọn dành cho không gian sống sang trọng.';

        return view('client.products.index', [
            'catalogCategories' => $catalogCategories,
            'featuredCategories' => $featuredCategories,
            'heroSlides' => $this->buildHeroSlides($featuredProducts, $selectedCategory, $search),
            'pageHeading' => $pageHeading,
            'pageDescription' => $pageDescription,
            'products' => $products,
            'selectedCategory' => $selectedCategory,
            'search' => $search,
        ]);
    }

    /**
     * Display the client product detail page.
     */
    public function show(Product $product): View
    {
        $product->load(['category', 'productImages']);

        $catalogCategories = Category::query()
            ->whereHas('products')
            ->withCount('products')
            ->latest()
            ->take(8)
            ->get();

        $galleryImages = collect([$product->image])
            ->merge($product->productImages->pluck('image'))
            ->filter()
            ->unique()
            ->values()
            ->map(
                fn (string $image, int $index): array => [
                    'image' => asset('storage/'.$image),
                    'alt' => $product->name.' - ảnh '.($index + 1),
                ]
            );

        if ($galleryImages->isEmpty()) {
            $galleryImages = collect([
                [
                    'image' => asset('images/baner1.jpg'),
                    'alt' => $product->name,
                ],
            ]);
        }

        $relatedProducts = Product::query()
            ->with('category')
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->getKey())
            ->whereNotNull('image')
            ->where('image', '!=', '')
            ->latest()
            ->take(4)
            ->get()
            ->values()
            ->map(fn (Product $relatedProduct, int $index): array => $this->mapProductCard($relatedProduct, $index));

        return view('client.products.show', [
            'catalogCategories' => $catalogCategories,
            'galleryImages' => $galleryImages,
            'priceText' => $this->formatPrice((float) $product->price),
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    /**
     * Build the hero slider from banners and highlighted products.
     *
     * @return \Illuminate\Support\Collection<int, array<string, string>>
     */
    protected function buildHeroSlides(
        Collection $featuredProducts,
        ?Category $selectedCategory,
        string $search
    ): Collection {
        $banners = Banner::query()
            ->latest()
            ->take(4)
            ->get()
            ->values();

        if ($banners->isNotEmpty()) {
            return $banners->map(function (Banner $banner, int $index) use ($featuredProducts, $selectedCategory, $search): array {
                $product = $featuredProducts->isNotEmpty()
                    ? $featuredProducts[$index % $featuredProducts->count()]
                    : null;

                return [
                    'eyebrow' => $selectedCategory?->name
                        ?? $product?->category?->name
                        ?? 'Nội thất cao cấp',
                    'title' => $banner->title
                        ? Str::limit($banner->title, 44, '...')
                        : 'Không gian sống mang dấu ấn riêng',
                    'description' => $search !== ''
                        ? 'Gợi ý sản phẩm phù hợp với nhu cầu tìm kiếm của bạn.'
                        : 'Tuyển chọn các thiết kế nổi bật cho phòng khách, phòng ngủ và khu vực trưng bày sang trọng.',
                    'background_image' => $banner->image
                        ? asset('storage/'.$banner->image)
                        : asset('images/baner1.jpg'),
                    'product_image' => $product?->image
                        ? asset('storage/'.$product->image)
                        : asset('images/baner1.jpg'),
                ];
            });
        }

        if ($featuredProducts->isNotEmpty()) {
            return $featuredProducts
                ->take(3)
                ->values()
                ->map(function (Product $product): array {
                    return [
                        'eyebrow' => $product->category?->name ?? 'Nội thất cao cấp',
                        'title' => Str::limit($product->name, 44, '...'),
                        'description' => filled($product->description)
                            ? Str::limit(strip_tags((string) $product->description), 120, '...')
                            : 'Thiết kế tinh tế, chất liệu chọn lọc và phù hợp với nhiều phong cách bài trí.',
                        'background_image' => asset('images/baner1.jpg'),
                        'product_image' => asset('storage/'.$product->image),
                    ];
                });
        }

        return collect([
            [
                'eyebrow' => $selectedCategory?->name ?? 'Nội thất cao cấp',
                'title' => 'Bộ sưu tập sản phẩm nổi bật',
                'description' => 'Trang sản phẩm đang được cập nhật thêm mẫu mới. Vui lòng quay lại sau để xem đầy đủ bộ sưu tập.',
                'background_image' => asset('images/baner1.jpg'),
                'product_image' => asset('images/baner1.jpg'),
            ],
        ]);
    }

    /**
     * Map a product to the showroom card structure.
     *
     * @return array<string, string>
     */
    protected function mapProductCard(Product $product, int $index): array
    {
        $badges = ['Nổi bật', 'Mới về', 'Bán chạy', 'Ưa chuộng'];
        $details = collect([$product->material, $product->color])->filter()->implode(' • ');

        return [
            'title' => $product->name,
            'price' => $this->formatPrice((float) $product->price),
            'image' => asset('storage/'.$product->image),
            'url' => route('client.products.show', $product),
            'badge' => $badges[$index % count($badges)],
            'category' => $product->category?->name ?? 'Nội thất cao cấp',
            'details' => $details !== '' ? $details : 'Thiết kế sang trọng cho không gian sống đẳng cấp',
            'stock' => $product->quantity > 0
                ? 'Còn '.$product->quantity.' sản phẩm'
                : 'Nhận đặt hàng',
        ];
    }

    /**
     * Format the product price for display.
     */
    protected function formatPrice(float $price): string
    {
        return $price > 0
            ? number_format($price, 0, ',', '.').' đ'
            : 'Liên hệ';
    }
}
