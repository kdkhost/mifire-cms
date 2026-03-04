<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $query = Category::with('parent');

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->orderBy('sort_order')->paginate(20)->withQueryString();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(Request $request)
    {
        $type = $request->input('type', 'product');
        $parents = Category::where('type', $type)->whereNull('parent_id')->orderBy('name')->get();

        return view('admin.categories.create', compact('type', 'parents'));
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'type'        => ['required', 'in:product,blog,download'],
            'parent_id'   => ['nullable', 'exists:categories,id'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('categories', 'public');
        }

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Category::create($validated);

        return redirect()->route('admin.categories.index', ['type' => $validated['type']])
            ->with('success', 'Categoria criada com sucesso.');
    }

    /**
     * Show the form for editing a category.
     */
    public function edit(Category $category)
    {
        $parents = Category::where('type', $category->type)
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
            'type'        => ['required', 'in:product,blog,download'],
            'parent_id'   => ['nullable', 'exists:categories,id'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')
                ->store('categories', 'public');
        }

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $category->sort_order;

        $category->update($validated);

        return redirect()->route('admin.categories.index', ['type' => $category->type])
            ->with('success', 'Categoria atualizada com sucesso.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $type = $category->type;
        $category->delete();

        return redirect()->route('admin.categories.index', ['type' => $type])
            ->with('success', 'Categoria excluída com sucesso.');
    }

    /**
     * Update sort order via AJAX.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items'        => ['required', 'array'],
            'items.*.id'   => ['required', 'exists:categories,id'],
            'items.*.order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Category::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
