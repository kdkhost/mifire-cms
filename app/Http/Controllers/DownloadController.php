<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Download;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DownloadController extends Controller
{
    /**
     * Display downloads page grouped by category (tabs).
     */
    public function index(): View
    {
        $categories = Category::active()
            ->byType('download')
            ->with(['downloads' => fn ($q) => $q->active()->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('site.downloads', compact('categories'));
    }

    /**
     * Increment download counter and return the file for download.
     */
    public function download(int $id): BinaryFileResponse
    {
        $download = Download::active()->findOrFail($id);

        $download->incrementDownload();

        $filePath = storage_path('app/public/' . $download->file_path);

        abort_unless(file_exists($filePath), 404, 'Arquivo não encontrado.');

        return response()->download($filePath, $download->title . '.' . pathinfo($filePath, PATHINFO_EXTENSION));
    }
}
