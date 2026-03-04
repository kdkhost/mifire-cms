<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisit
{
    /**
     * Routes / prefixes that should NOT be tracked.
     */
    protected array $excludedPrefixes = [
        'admin',
        'install',
        'api',
        '_debugbar',
    ];

    /**
     * File extensions that indicate asset requests (not real page visits).
     */
    protected array $assetExtensions = [
        'css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico',
        'woff', 'woff2', 'ttf', 'eot', 'map', 'webp', 'avif',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track GET requests that return HTML pages
        if (! $request->isMethod('GET')) {
            return $response;
        }

        // Skip excluded prefixes
        foreach ($this->excludedPrefixes as $prefix) {
            if ($request->is($prefix) || $request->is("{$prefix}/*")) {
                return $response;
            }
        }

        // Skip asset requests
        $path = $request->path();
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if ($extension && in_array(strtolower($extension), $this->assetExtensions)) {
            return $response;
        }

        // Skip AJAX / JSON requests
        if ($request->expectsJson()) {
            return $response;
        }

        // Record the visit
        try {
            Visit::recordVisit($request);
        } catch (\Throwable $e) {
            // Silently fail — visit tracking should never break the site
            report($e);
        }

        return $response;
    }
}
