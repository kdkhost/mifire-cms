<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    /**
     * Display a listing of brands.
     */
    public function index()
    {
        $brands = Brand::orderBy('sort_order')->get();

        return view('admin.brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created brand.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'url' => ['nullable', 'url', 'max:500'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')
                ->store('brands', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Brand::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Marca criada com sucesso.',
                'redirect' => route('admin.brands.index')
            ]);
        }

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca criada com sucesso.');
    }

    /**
     * Show the form for editing a brand.
     */
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified brand.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'url' => ['nullable', 'url', 'max:500'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('logo')) {
            if ($brand->logo) {
                Storage::disk('public')->delete($brand->logo);
            }
            $validated['logo'] = $request->file('logo')
                ->store('brands', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $brand->sort_order;

        $brand->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Marca atualizada com sucesso.',
                'redirect' => route('admin.brands.index')
            ]);
        }

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca atualizada com sucesso.');
    }

    /**
     * Remove the specified brand.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->logo) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')
            ->with('success', 'Marca excluída com sucesso.');
    }

    /**
     * Update sort order via AJAX.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'exists:brands,id'],
            'items.*.order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Brand::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
