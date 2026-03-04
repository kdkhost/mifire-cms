<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $products   = $query->orderBy('sort_order')->paginate(15)->withQueryString();
        $categories = Category::where('type', 'product')->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('type', 'product')->orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'       => ['nullable', 'exists:categories,id'],
            'name'              => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'image'             => ['nullable', 'image', 'max:2048'],
            'gallery.*'         => ['nullable', 'image', 'max:2048'],
            'specifications'    => ['nullable', 'array'],
            'specifications.keys.*'   => ['nullable', 'string', 'max:255'],
            'specifications.values.*' => ['nullable', 'string', 'max:255'],
            'datasheet'         => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
            'is_featured'       => ['boolean'],
            'is_active'         => ['boolean'],
            'sort_order'        => ['nullable', 'integer'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:500'],
        ]);

        // Main image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        // Gallery
        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
        }
        $validated['gallery'] = $gallery;

        // Specifications (key-value pairs)
        $specs = [];
        if ($request->has('specifications.keys')) {
            $keys   = $request->input('specifications.keys', []);
            $values = $request->input('specifications.values', []);
            foreach ($keys as $i => $key) {
                if (! empty($key)) {
                    $specs[$key] = $values[$i] ?? '';
                }
            }
        }
        $validated['specifications'] = $specs;

        // Datasheet
        if ($request->hasFile('datasheet')) {
            $validated['datasheet_url'] = $request->file('datasheet')
                ->store('products/datasheets', 'public');
        }
        unset($validated['datasheet']);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active']   = $request->boolean('is_active');
        $validated['sort_order']  = $validated['sort_order'] ?? 0;

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto criado com sucesso.');
    }

    /**
     * Show the form for editing a product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('type', 'product')->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id'       => ['nullable', 'exists:categories,id'],
            'name'              => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description'       => ['nullable', 'string'],
            'image'             => ['nullable', 'image', 'max:2048'],
            'gallery.*'         => ['nullable', 'image', 'max:2048'],
            'specifications'    => ['nullable', 'array'],
            'specifications.keys.*'   => ['nullable', 'string', 'max:255'],
            'specifications.values.*' => ['nullable', 'string', 'max:255'],
            'datasheet'         => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx', 'max:10240'],
            'is_featured'       => ['boolean'],
            'is_active'         => ['boolean'],
            'sort_order'        => ['nullable', 'integer'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:500'],
        ]);

        // Main image
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        // Gallery — merge with existing or replace
        $gallery = $product->gallery ?? [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
        }
        // Remove selected gallery images
        if ($removeImages = $request->input('remove_gallery', [])) {
            foreach ($removeImages as $path) {
                Storage::disk('public')->delete($path);
                $gallery = array_values(array_diff($gallery, [$path]));
            }
        }
        $validated['gallery'] = $gallery;

        // Specifications
        $specs = [];
        if ($request->has('specifications.keys')) {
            $keys   = $request->input('specifications.keys', []);
            $values = $request->input('specifications.values', []);
            foreach ($keys as $i => $key) {
                if (! empty($key)) {
                    $specs[$key] = $values[$i] ?? '';
                }
            }
        }
        $validated['specifications'] = $specs;

        // Datasheet
        if ($request->hasFile('datasheet')) {
            if ($product->datasheet_url) {
                Storage::disk('public')->delete($product->datasheet_url);
            }
            $validated['datasheet_url'] = $request->file('datasheet')
                ->store('products/datasheets', 'public');
        }
        unset($validated['datasheet']);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active']   = $request->boolean('is_active');
        $validated['sort_order']  = $validated['sort_order'] ?? $product->sort_order;

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto atualizado com sucesso.');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        if ($product->gallery) {
            foreach ($product->gallery as $path) {
                Storage::disk('public')->delete($path);
            }
        }
        if ($product->datasheet_url) {
            Storage::disk('public')->delete($product->datasheet_url);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produto excluído com sucesso.');
    }

    /**
     * Toggle featured status via AJAX.
     */
    public function toggleFeatured(Product $product)
    {
        $product->update(['is_featured' => ! $product->is_featured]);

        return response()->json([
            'success'     => true,
            'is_featured' => $product->is_featured,
        ]);
    }

    /**
     * Toggle active status via AJAX.
     */
    public function toggleActive(Product $product)
    {
        $product->update(['is_active' => ! $product->is_active]);

        return response()->json([
            'success'   => true,
            'is_active' => $product->is_active,
        ]);
    }
}
