<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogPostController extends Controller
{
    /**
     * Display a listing of blog posts.
     */
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'user']);

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        if ($request->has('is_published')) {
            $query->where('is_published', $request->boolean('is_published'));
        }

        $posts = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::where('type', 'blog')->orderBy('name')->get();

        return view('admin.blog.index', compact('posts', 'categories'));
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create()
    {
        $categories = Category::where('type', 'blog')->orderBy('name')->get();

        return view('admin.blog.create', compact('categories'));
    }

    /**
     * Store a newly created blog post.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_published' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blog', 'public');
        }

        $validated['user_id'] = Auth::id();
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        BlogPost::create($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post criado com sucesso.',
                'redirect' => route('admin.blog.index')
            ]);
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post criado com sucesso.');
    }

    /**
     * Show the form for editing a blog post.
     */
    public function edit(BlogPost $blog)
    {
        $categories = Category::where('type', 'blog')->orderBy('name')->get();

        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    /**
     * Update the specified blog post.
     */
    public function update(Request $request, BlogPost $blog)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['nullable', 'string'],
            'featured_image' => ['nullable', 'image', 'max:2048'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_published' => ['boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('blog', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        // Set published_at when publishing for the first time
        if ($validated['is_published'] && !$blog->published_at) {
            $validated['published_at'] = now();
        }
        // Clear published_at when unpublishing
        if (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        $blog->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Post atualizado com sucesso.',
                'redirect' => route('admin.blog.index')
            ]);
        }

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post atualizado com sucesso.');
    }

    /**
     * Remove the specified blog post.
     */
    public function destroy(BlogPost $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post excluído com sucesso.');
    }

    /**
     * Toggle publish status via AJAX.
     */
    public function togglePublish(BlogPost $blog)
    {
        $isPublished = !$blog->is_published;

        $blog->update([
            'is_published' => $isPublished,
            'published_at' => $isPublished ? ($blog->published_at ?? now()) : null,
        ]);

        return response()->json([
            'success' => true,
            'is_published' => $blog->is_published,
        ]);
    }

    /**
     * Preview a blog post.
     */
    public function preview(BlogPost $blog)
    {
        return view('admin.blog.preview', compact('blog'));
    }
}
