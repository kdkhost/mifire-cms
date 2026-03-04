<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * List all product categories with their products.
     */
    public function index(Request $request): View
    {
        $categories = Category::active()
            ->byType('product')
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        $query = Product::active()->with('category')->orderBy('sort_order');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        $products = $query->paginate(12)->withQueryString();

        return view('site.products.index', compact('categories', 'products'));
    }

    /**
     * List products within a specific category.
     */
    public function category(string $slug): View
    {
        $category = Category::active()
            ->byType('product')
            ->where('slug', $slug)
            ->firstOrFail();

        $products = Product::active()
            ->where('category_id', $category->id)
            ->orderBy('sort_order')
            ->paginate(12);

        $categories = Category::active()
            ->byType('product')
            ->withCount(['products' => fn ($q) => $q->active()])
            ->orderBy('sort_order')
            ->get();

        return view('site.products.category', compact('category', 'products', 'categories'));
    }

    /**
     * Display a single product.
     */
    public function show(string $categorySlug, string $slug): View
    {
        $category = Category::active()
            ->byType('product')
            ->where('slug', $categorySlug)
            ->firstOrFail();

        $product = Product::active()
            ->where('category_id', $category->id)
            ->where('slug', $slug)
            ->firstOrFail();

        $relatedProducts = Product::active()
            ->where('category_id', $category->id)
            ->where('id', '!=', $product->id)
            ->orderBy('sort_order')
            ->take(4)
            ->get();

        return view('site.products.show', compact('category', 'product', 'relatedProducts'));
    }
}
