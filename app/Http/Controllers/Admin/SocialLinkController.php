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
            'platform' => ['required', 'string', 'max:100'],
            'url' => ['required', 'url', 'max:500'],
            'icon' => ['nullable', 'string', 'max:255'],
            'icon_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('icon_file')) {
            $path = $request->file('icon_file')->store('social-icons', 'public');
            $validated['icon'] = $path;
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        SocialLink::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Rede social criada com sucesso.',
            'redirect' => route('admin.social-links.index')
        ]);
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
            'platform' => ['required', 'string', 'max:100'],
            'url' => ['required', 'url', 'max:500'],
            'icon' => ['nullable', 'string', 'max:255'],
            'icon_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:1024'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('icon_file')) {
            // Remove old icon if it's a file
            if ($socialLink->icon && \Storage::disk('public')->exists($socialLink->icon)) {
                \Storage::disk('public')->delete($socialLink->icon);
            }

            $path = $request->file('icon_file')->store('social-icons', 'public');
            $validated['icon'] = $path;
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $socialLink->sort_order;

        $socialLink->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Rede social atualizada com sucesso.',
            'redirect' => route('admin.social-links.index')
        ]);
    }

    /**
     * Remove the specified social link.
     */
    public function destroy(SocialLink $socialLink)
    {
        if ($socialLink->icon && \Storage::disk('public')->exists($socialLink->icon)) {
            \Storage::disk('public')->delete($socialLink->icon);
        }

        $socialLink->delete();

        return redirect()->route('admin.social-links.index')
            ->with('success', 'Rede social excluída com sucesso.');
    }
}
