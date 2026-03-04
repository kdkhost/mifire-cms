<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PwaController extends Controller
{
    /**
     * Generate the PWA manifest.json from settings.
     */
    public function manifest(): JsonResponse
    {
        $siteName = Setting::get('site_name', config('app.name'));
        $shortName = Setting::get('pwa_short_name', $siteName);
        $themeColor = Setting::get('pwa_theme_color', '#dc2626');
        $backgroundColor = Setting::get('pwa_background_color', '#ffffff');
        $icon192 = Setting::get('pwa_icon_192', '/images/icons/icon-192x192.png');
        $icon512 = Setting::get('pwa_icon_512', '/images/icons/icon-512x512.png');

        $manifest = [
            'name'             => $siteName,
            'short_name'       => $shortName,
            'start_url'        => '/',
            'display'          => 'standalone',
            'orientation'      => 'portrait',
            'theme_color'      => $themeColor,
            'background_color' => $backgroundColor,
            'icons'            => [
                [
                    'src'     => $icon192,
                    'sizes'   => '192x192',
                    'type'    => 'image/png',
                    'purpose' => 'any maskable',
                ],
                [
                    'src'     => $icon512,
                    'sizes'   => '512x512',
                    'type'    => 'image/png',
                    'purpose' => 'any maskable',
                ],
            ],
        ];

        return response()->json($manifest)->header('Content-Type', 'application/manifest+json');
    }

    /**
     * Display the offline fallback page.
     */
    public function offline(): View
    {
        return view('site.offline');
    }

    /**
     * Return the service worker JavaScript file.
     */
    public function serviceWorker(): Response
    {
        $offlineUrl = route('offline');

        $js = <<<JS
const CACHE_NAME = 'mifire-cache-v1';
const OFFLINE_URL = '{$offlineUrl}';

const PRECACHE_URLS = [
    '/',
    OFFLINE_URL,
    '/css/app.css',
    '/js/app.js',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(PRECACHE_URLS))
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) =>
            Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name))
            )
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    if (event.request.mode === 'navigate') {
        event.respondWith(
            fetch(event.request).catch(() => caches.match(OFFLINE_URL))
        );
        return;
    }

    event.respondWith(
        caches.match(event.request).then((response) => response || fetch(event.request))
    );
});
JS;

        return response($js, 200, [
            'Content-Type'  => 'application/javascript',
            'Cache-Control' => 'no-cache',
        ]);
    }
}
