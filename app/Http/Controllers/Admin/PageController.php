<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Display a listing of pages.
     */
    public function index(Request $request)
    {
        $query = Page::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        $pages = $query->orderBy('sort_order')->paginate(15)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created page.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'content'          => ['nullable', 'string'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords'    => ['nullable', 'string', 'max:500'],
            'featured_image'   => ['nullable', 'image', 'max:2048'],
            'template'         => ['nullable', 'string', 'max:100'],
            'is_active'        => ['boolean'],
            'sort_order'       => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('pages', 'public');
        }

        $validated['is_active']   = $request->boolean('is_active');
        $validated['sort_order']  = $validated['sort_order'] ?? 0;

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Página criada com sucesso.');
    }

    /**
     * Show the form for editing a page.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified page.
     */
    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'content'          => ['nullable', 'string'],
            'meta_title'       => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords'    => ['nullable', 'string', 'max:500'],
            'featured_image'   => ['nullable', 'image', 'max:2048'],
            'template'         => ['nullable', 'string', 'max:100'],
            'is_active'        => ['boolean'],
            'sort_order'       => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($page->featured_image) {
                Storage::disk('public')->delete($page->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('pages', 'public');
        }

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $page->sort_order;

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Página atualizada com sucesso.');
    }

    /**
     * Remove the specified page.
     */
    public function destroy(Page $page)
    {
        if ($page->featured_image) {
            Storage::disk('public')->delete($page->featured_image);
        }

        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Página excluída com sucesso.');
    }

    /**
     * Toggle active status via AJAX.
     */
    public function toggleActive(Page $page)
    {
        $page->update(['is_active' => ! $page->is_active]);

        return response()->json([
            'success'   => true,
            'is_active' => $page->is_active,
        ]);
    }
}
