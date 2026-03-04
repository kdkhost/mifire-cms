<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Banner;
use App\Models\BlogPost;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the home page.
     */
    public function index(): View
    {
        $banners = Banner::active()->ordered()->get();

        $featuredProducts = Product::active()
            ->featured()
            ->with('category')
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $latestPosts = BlogPost::published()
            ->recent()
            ->with('category')
            ->take(3)
            ->get();

        $brands = Brand::active()
            ->orderBy('sort_order')
            ->get();

        $addresses = Address::active()
            ->orderBy('sort_order')
            ->get();

        return view('site.home', compact(
            'banners',
            'featuredProducts',
            'latestPosts',
            'brands',
            'addresses',
        ));
    }
}
