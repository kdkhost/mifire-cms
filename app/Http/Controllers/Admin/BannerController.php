<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Display a listing of banners.
     */
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->get();

        return view('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new banner.
     */
    public function create()
    {
        return view('admin.banners.create');
    }

    /**
     * Store a newly created banner.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['required', 'image', 'max:4096'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url'  => ['nullable', 'string', 'max:500'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        $validated['image'] = $request->file('image')
            ->store('banners', 'public');

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Banner::create($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner criado com sucesso.');
    }

    /**
     * Show the form for editing a banner.
     */
    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    /**
     * Update the specified banner.
     */
    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'subtitle'    => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:4096'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_url'  => ['nullable', 'string', 'max:500'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $request->file('image')
                ->store('banners', 'public');
        }

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $banner->sort_order;

        $banner->update($validated);

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner atualizado com sucesso.');
    }

    /**
     * Remove the specified banner.
     */
    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')
            ->with('success', 'Banner excluído com sucesso.');
    }

    /**
     * Update sort order via AJAX.
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'items'         => ['required', 'array'],
            'items.*.id'    => ['required', 'exists:banners,id'],
            'items.*.order' => ['required', 'integer'],
        ]);

        foreach ($request->input('items') as $item) {
            Banner::where('id', $item['id'])->update(['sort_order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
