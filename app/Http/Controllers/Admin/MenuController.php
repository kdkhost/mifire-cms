<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of menus.
     */
    public function index(Request $request)
    {
        $location = $request->input('location', 'main');

        $menus = Menu::with('children')
            ->where('location', $location)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        return view('admin.menus.index', compact('menus', 'location'));
    }

    /**
     * Show the form for creating a new menu item.
     */
    public function create(Request $request)
    {
        $location = $request->input('location', 'main');

        $parents = Menu::where('location', $location)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $pages = Page::active()->orderBy('title')->get();

        return view('admin.menus.create', compact('location', 'parents', 'pages'));
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'     => ['required', 'string', 'max:255'],
            'url'       => ['nullable', 'string', 'max:500'],
            'page_id'   => ['nullable', 'exists:pages,id'],
            'parent_id' => ['nullable', 'exists:menus,id'],
            'target'    => ['nullable', 'in:_self,_blank'],
            'icon'      => ['nullable', 'string', 'max:100'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
            'location'  => ['required', 'in:main,footer'],
        ]);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Menu::create($validated);

        return redirect()->route('admin.menus.index', ['location' => $validated['location']])
            ->with('success', 'Item de menu criado com sucesso.');
    }

    /**
     * Show the form for editing a menu item.
     */
    public function edit(Menu $menu)
    {
        $parents = Menu::where('location', $menu->location)
            ->whereNull('parent_id')
            ->where('id', '!=', $menu->id)
            ->orderBy('sort_order')
            ->get();

        $pages = Page::active()->orderBy('title')->get();

        return view('admin.menus.edit', [
            'menu' => $menu,
            'parentMenus' => $parents,
            'pages' => $pages,
        ]);
    }

    /**
     * Update the specified menu item.
     */
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title'      => ['required', 'string', 'max:255'],
            'url'        => ['nullable', 'string', 'max:500'],
            'page_id'    => ['nullable', 'exists:pages,id'],
            'parent_id'  => ['nullable', 'exists:menus,id'],
            'target'     => ['nullable', 'in:_self,_blank'],
            'icon'       => ['nullable', 'string', 'max:100'],
            'is_active'  => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
            'location'   => ['required', 'in:main,footer'],
        ]);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $menu->sort_order;

        $menu->update($validated);

        return redirect()->route('admin.menus.index', ['location' => $menu->location])
            ->with('success', 'Item de menu atualizado com sucesso.');
    }

    /**
     * Remove the specified menu item.
     */
    public function destroy(Menu $menu)
    {
        $location = $menu->location;

        // Delete children first
        $menu->children()->delete();
        $menu->delete();

        return redirect()->route('admin.menus.index', ['location' => $location])
            ->with('success', 'Item de menu excluído com sucesso.');
    }

    /**
     * Update nested order via AJAX (drag & drop).
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items'             => ['required', 'array'],
            'items.*.id'        => ['required', 'exists:menus,id'],
            'items.*.order'     => ['required', 'integer'],
            'items.*.parent_id' => ['nullable', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Menu::where('id', $item['id'])->update([
                'sort_order' => $item['order'],
                'parent_id'  => $item['parent_id'] ?? null,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
