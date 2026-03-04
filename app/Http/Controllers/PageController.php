<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a CMS page by its slug.
     */
    public function show(string $slug): View
    {
        $page = Page::active()->where('slug', $slug)->firstOrFail();

        // Use a specific template view if defined, otherwise fall back to generic page view
        $template = $page->template
            ? "site.pages.{$page->template}"
            : 'site.page';

        // Check if the template view exists; fall back to the default
        if ($page->template && !view()->exists($template)) {
            $template = 'site.page';
        }

        return view($template, compact('page'));
    }
}
