<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    /**
     * Display a listing of social links.
     */
    public function index()
    {
        $socialLinks = SocialLink::orderBy('sort_order')->get();

        return view('admin.social-links.index', compact('socialLinks'));
    }

    /**
     * Show the form for creating a new social link.
     */
    public function create()
    {
        return view('admin.social-links.create');
    }

    /**
     * Store a newly created social link.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform'   => ['required', 'string', 'max:100'],
            'url'        => ['required', 'url', 'max:500'],
            'icon'       => ['nullable', 'string', 'max:100'],
            'is_active'  => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        SocialLink::create($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Rede social criada com sucesso.');
    }

    /**
     * Show the form for editing a social link.
     */
    public function edit(SocialLink $socialLink)
    {
        return view('admin.social-links.edit', compact('socialLink'));
    }

    /**
     * Update the specified social link.
     */
    public function update(Request $request, SocialLink $socialLink)
    {
        $validated = $request->validate([
            'platform'   => ['required', 'string', 'max:100'],
            'url'        => ['required', 'url', 'max:500'],
            'icon'       => ['nullable', 'string', 'max:100'],
            'is_active'  => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $socialLink->sort_order;

        $socialLink->update($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Rede social atualizada com sucesso.');
    }

    /**
     * Remove the specified social link.
     */
    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Rede social excluída com sucesso.');
    }
}
