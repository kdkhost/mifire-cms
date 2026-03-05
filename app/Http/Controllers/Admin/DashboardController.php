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
        $visitsToday = Visit::today()->count();
        $visitsWeek = Visit::thisWeek()->count();
        $visitsMonth = Visit::thisMonth()->count();
        $unreadContacts = Contact::unread()->count();
        $totalPosts = BlogPost::count();
        $totalProducts = Product::count();

        // ── Recent contacts ───────────────────────────────
        $recentContacts = Contact::latest()->take(5)->get();

        // ── Top pages (last 30 days) ──────────────────────
        $topPages = Visit::select('url', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact(
            'visitsToday',
            'visitsWeek',
            'visitsMonth',
            'unreadContacts',
            'totalPosts',
            'totalProducts',
            'recentContacts',
            'topPages'
        ));
    }

    /**
     * Return chart data as JSON.
     */
    public function chartData()
    {
        $days = 30;
        $from = Carbon::now()->subDays($days);

        // 1. Visits per day
        $visitsRaw = Visit::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total')
        )
            ->where('created_at', '>=', $from)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        $labels = [];
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::parse($date)->format('d/m');
            $data[] = $visitsRaw[$date] ?? 0;
        }

        // 2. Browsers
        $browsersRaw = Visit::select('browser', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $from)
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->get();

        return response()->json([
            'visits' => [
                'labels' => $labels,
                'data' => $data,
            ],
            'browsers' => [
                'labels' => $browsersRaw->pluck('browser'),
                'data' => $browsersRaw->pluck('total'),
            ]
        ]);
    }
}
