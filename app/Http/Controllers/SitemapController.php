<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Generate an XML sitemap with all active pages, products, and blog posts.
     */
    public function index(): Response
    {
        $pages = Page::active()->orderBy('updated_at', 'desc')->get();

        $categories = Category::active()
            ->byType('product')
            ->orderBy('updated_at', 'desc')
            ->get();

        $products = Product::active()
            ->with('category')
            ->orderBy('updated_at', 'desc')
            ->get();

        $posts = BlogPost::published()
            ->recent()
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Home
        $xml .= $this->urlEntry(route('home'), now()->toAtomString(), 'daily', '1.0');

        // CMS Pages
        foreach ($pages as $page) {
            $xml .= $this->urlEntry(
                route('page.show', $page->slug),
                $page->updated_at->toAtomString(),
                'weekly',
                '0.8',
            );
        }

        // Product categories
        foreach ($categories as $category) {
            $xml .= $this->urlEntry(
                route('products.category', $category->slug),
                $category->updated_at->toAtomString(),
                'weekly',
                '0.8',
            );
        }

        // Products
        foreach ($products as $product) {
            if ($product->category) {
                $xml .= $this->urlEntry(
                    route('products.show', [$product->category->slug, $product->slug]),
                    $product->updated_at->toAtomString(),
                    'weekly',
                    '0.7',
                );
            }
        }

        // Blog posts
        foreach ($posts as $post) {
            $xml .= $this->urlEntry(
                route('blog.show', $post->slug),
                $post->updated_at->toAtomString(),
                'weekly',
                '0.6',
            );
        }

        // Blog index
        $xml .= $this->urlEntry(route('blog.index'), now()->toAtomString(), 'daily', '0.7');

        // Products index
        $xml .= $this->urlEntry(route('products.index'), now()->toAtomString(), 'daily', '0.8');

        // Contact
        $xml .= $this->urlEntry(route('contact.index'), now()->toAtomString(), 'monthly', '0.5');

        // Downloads
        $xml .= $this->urlEntry(route('downloads.index'), now()->toAtomString(), 'weekly', '0.5');

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }

    /**
     * Build a single <url> sitemap entry.
     */
    protected function urlEntry(string $loc, string $lastmod, string $changefreq, string $priority): string
    {
        return "  <url>\n"
            . "    <loc>{$loc}</loc>\n"
            . "    <lastmod>{$lastmod}</lastmod>\n"
            . "    <changefreq>{$changefreq}</changefreq>\n"
            . "    <priority>{$priority}</priority>\n"
            . "  </url>\n";
    }
}
