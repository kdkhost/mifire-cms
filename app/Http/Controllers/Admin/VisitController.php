<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VisitController extends Controller
{
    /**
     * Display a listing of visits.
     */
    public function index(Request $request)
    {
        $query = Visit::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('ip_address', 'like', "%{$search}%")
                  ->orWhere('url', 'like', "%{$search}%");
            });
        }

        if ($from = $request->input('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $visits = $query->latest('created_at')->paginate(30)->withQueryString();

        return view('admin.visits.index', compact('visits'));
    }

    /**
     * Return chart / stats data as JSON.
     */
    public function stats(Request $request)
    {
        $days = (int) $request->input('days', 30);
        $from = Carbon::now()->subDays($days);

        // Visits per day
        $perDay = Visit::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', $from)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date')
            ->toArray();

        // Fill missing days
        $visitsPerDay = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $visitsPerDay[$date] = $perDay[$date] ?? 0;
        }

        // Browsers
        $browsers = Visit::select('browser', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $from)
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'browser');

        // Operating Systems
        $operatingSystems = Visit::select('os', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $from)
            ->whereNotNull('os')
            ->groupBy('os')
            ->orderByDesc('total')
            ->limit(10)
            ->pluck('total', 'os');

        // Devices
        $devices = Visit::select('device', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $from)
            ->whereNotNull('device')
            ->groupBy('device')
            ->orderByDesc('total')
            ->pluck('total', 'device');

        // Top pages
        $topPages = Visit::select('url', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $from)
            ->groupBy('url')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return response()->json(compact(
            'visitsPerDay',
            'browsers',
            'operatingSystems',
            'devices',
            'topPages'
        ));
    }

    /**
     * Export visits to CSV.
     */
    public function export(Request $request)
    {
        $query = Visit::query();

        if ($from = $request->input('from')) {
            $query->whereDate('created_at', '>=', $from);
        }

        if ($to = $request->input('to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $visits = $query->latest('created_at')->get();

        $filename = 'visitas_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($visits) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['ID', 'IP', 'URL', 'Navegador', 'SO', 'Dispositivo', 'Referer', 'Data']);

            foreach ($visits as $visit) {
                fputcsv($file, [
                    $visit->id,
                    $visit->ip_address,
                    $visit->url,
                    $visit->browser,
                    $visit->os,
                    $visit->device,
                    $visit->referer,
                    $visit->created_at?->format('d/m/Y H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
