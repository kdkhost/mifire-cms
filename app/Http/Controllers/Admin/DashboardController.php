<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Visit;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        // ── Stats ─────────────────────────────────────────
        $visitsToday  = Visit::today()->count();
        $visitsWeek   = Visit::thisWeek()->count();
        $visitsMonth  = Visit::thisMonth()->count();

        $contactsUnread = Contact::unread()->count();
        $totalBlogPosts = BlogPost::count();
        $totalProducts  = Product::count();

        // ── Recent contacts ───────────────────────────────
        $recentContacts = Contact::latest()->take(5)->get();

        // ── Visits chart data (last 30 days) ──────────────
        $chartData = Visit::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->mapWithKeys(fn ($row) => [$row->date => $row->total])
            ->toArray();

        // Fill missing days with zero
        $visitsChart = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $visitsChart[$date] = $chartData[$date] ?? 0;
        }

        // ── Popular pages (top 10) ────────────────────────
        $popularPages = Visit::select('url', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'visitsToday',
            'visitsWeek',
            'visitsMonth',
            'contactsUnread',
            'totalBlogPosts',
            'totalProducts',
            'recentContacts',
            'visitsChart',
            'popularPages'
        ));
    }
}
