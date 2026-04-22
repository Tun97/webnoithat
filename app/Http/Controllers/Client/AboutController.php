<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display the about page.
     */
    public function index(): View
    {
        $catalogCategories = Category::query()
            ->whereHas('products')
            ->withCount('products')
            ->latest()
            ->take(8)
            ->get();

        return view('client.about.index', [
            'catalogCategories' => $catalogCategories,
            'aboutImage' => asset('images/About-us.png'),
        ]);
    }
}
