<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Display a listing of downloads.
     */
    public function index(Request $request)
    {
        $query = Download::with('category');

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $downloads  = $query->orderBy('sort_order')->paginate(15)->withQueryString();
        $categories = Category::where('type', 'download')->orderBy('name')->get();

        return view('admin.downloads.index', compact('downloads', 'categories'));
    }

    /**
     * Show the form for creating a new download.
     */
    public function create()
    {
        $categories = Category::where('type', 'download')->orderBy('name')->get();

        return view('admin.downloads.create', compact('categories'));
    }

    /**
     * Store a newly created download.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file'        => ['required', 'file', 'max:20480'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        $file = $request->file('file');
        $validated['file_path'] = $file->store('downloads', 'public');
        $validated['file_size'] = $file->getSize();
        unset($validated['file']);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Download::create($validated);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Download criado com sucesso.');
    }

    /**
     * Show the form for editing a download.
     */
    public function edit(Download $download)
    {
        $categories = Category::where('type', 'download')->orderBy('name')->get();

        return view('admin.downloads.edit', compact('download', 'categories'));
    }

    /**
     * Update the specified download.
     */
    public function update(Request $request, Download $download)
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'file'        => ['nullable', 'file', 'max:20480'],
            'is_active'   => ['boolean'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        if ($request->hasFile('file')) {
            if ($download->file_path) {
                Storage::disk('public')->delete($download->file_path);
            }
            $file = $request->file('file');
            $validated['file_path'] = $file->store('downloads', 'public');
            $validated['file_size'] = $file->getSize();
        }
        unset($validated['file']);

        $validated['is_active']  = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? $download->sort_order;

        $download->update($validated);

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Download atualizado com sucesso.');
    }

    /**
     * Remove the specified download.
     */
    public function destroy(Download $download)
    {
        if ($download->file_path) {
            Storage::disk('public')->delete($download->file_path);
        }

        $download->delete();

        return redirect()->route('admin.downloads.index')
            ->with('success', 'Download excluído com sucesso.');
    }
}
