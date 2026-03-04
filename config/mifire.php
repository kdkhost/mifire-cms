<?php

return [

    /*
    |--------------------------------------------------------------------------
    | MiFire CMS Configuration
    |--------------------------------------------------------------------------
    */

    // CMS Version
    'version' => '1.0.0',

    // ── Developer Info ───────────────────────────────────────
    'developer' => [
        'name'    => 'George Marcelo',
        'company' => 'KDKHost Soluções',
        'url'     => 'https://www.kdkhost.com.br',
        'email'   => 'contato@kdkhost.com.br',
    ],

    // ── Company Info (defaults, overridden by settings table) ─
    'company' => [
        'name'      => env('MIFIRE_COMPANY_NAME', 'MiFire'),
        'address'   => env('MIFIRE_COMPANY_ADDRESS', ''),
        'phone'     => env('MIFIRE_COMPANY_PHONE', ''),
        'email'     => env('MIFIRE_COMPANY_EMAIL', ''),
        'facebook'  => env('MIFIRE_FACEBOOK', ''),
        'instagram' => env('MIFIRE_INSTAGRAM', ''),
        'linkedin'  => env('MIFIRE_LINKEDIN', ''),
        'youtube'   => env('MIFIRE_YOUTUBE', ''),
        'whatsapp'  => env('MIFIRE_WHATSAPP', ''),
    ],

    // ── Upload Limits ────────────────────────────────────────
    'uploads' => [
        'max_file_size'  => env('MIFIRE_MAX_FILE_SIZE', 10240),   // KB (10MB)
        'max_image_size' => env('MIFIRE_MAX_IMAGE_SIZE', 5120),    // KB (5MB)
        'max_width'      => env('MIFIRE_MAX_IMAGE_WIDTH', 2560),   // pixels
        'max_height'     => env('MIFIRE_MAX_IMAGE_HEIGHT', 2560),  // pixels
        'thumb_width'    => 400,
        'thumb_height'   => 300,
        'quality'        => 85,
        'allowed_images' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
        'allowed_files'  => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar'],
    ],

    // ── Pagination ───────────────────────────────────────────
    'pagination' => [
        'admin'    => env('MIFIRE_ADMIN_PER_PAGE', 15),
        'products' => env('MIFIRE_PRODUCTS_PER_PAGE', 12),
        'blog'     => env('MIFIRE_BLOG_PER_PAGE', 9),
        'downloads'=> env('MIFIRE_DOWNLOADS_PER_PAGE', 12),
    ],

    // ── Cache TTL (seconds) ──────────────────────────────────
    'cache' => [
        'settings'   => env('MIFIRE_CACHE_SETTINGS', 3600),     // 1 hour
        'menus'      => env('MIFIRE_CACHE_MENUS', 3600),        // 1 hour
        'pages'      => env('MIFIRE_CACHE_PAGES', 1800),        // 30 min
        'products'   => env('MIFIRE_CACHE_PRODUCTS', 1800),     // 30 min
        'categories' => env('MIFIRE_CACHE_CATEGORIES', 3600),   // 1 hour
        'banners'    => env('MIFIRE_CACHE_BANNERS', 1800),      // 30 min
        'blog'       => env('MIFIRE_CACHE_BLOG', 1800),         // 30 min
        'sitemap'    => env('MIFIRE_CACHE_SITEMAP', 86400),     // 24 hours
    ],

    // ── Visit Tracking ───────────────────────────────────────
    'tracking' => [
        'enabled'      => env('MIFIRE_TRACKING_ENABLED', true),
        'exclude_bots' => env('MIFIRE_TRACKING_EXCLUDE_BOTS', true),
        'exclude_ips'  => array_filter(
            explode(',', env('MIFIRE_TRACKING_EXCLUDE_IPS', '127.0.0.1'))
        ),
        'retention_days' => env('MIFIRE_TRACKING_RETENTION', 90), // days to keep
    ],

    // ── SEO Defaults ─────────────────────────────────────────
    'seo' => [
        'title_separator' => ' | ',
        'title_suffix'    => 'MiFire - Soluções de Combate a Incêndio',
        'default_image'   => '/images/og-default.jpg',
    ],

    // ── Admin ────────────────────────────────────────────────
    'admin' => [
        'prefix'         => 'admin',
        'dashboard_route'=> 'admin.dashboard',
    ],

];
