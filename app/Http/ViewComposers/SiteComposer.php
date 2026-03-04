<?php

namespace App\Http\ViewComposers;

use App\Models\Address;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\SocialLink;
use Illuminate\View\View;

class SiteComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Main menu items with children (header)
        $menus = Menu::active()
            ->byLocation('main')
            ->whereNull('parent_id')
            ->with(['children' => fn($q) => $q->active()->orderBy('sort_order'), 'page'])
            ->orderBy('sort_order')
            ->get();

        // Footer menu items
        $footerMenus = Menu::active()
            ->byLocation('footer')
            ->whereNull('parent_id')
            ->with(['children' => fn($q) => $q->active()->orderBy('sort_order'), 'page'])
            ->orderBy('sort_order')
            ->get();

        // Active social links
        $socialLinks = SocialLink::active()
            ->orderBy('sort_order')
            ->get();

        // Active addresses
        $addresses = Address::active()
            ->orderBy('sort_order')
            ->get();

        // All settings as key-value collection
        $settings = Setting::pluck('value', 'key');

        // PWA enabled flag
        $pwaEnabled = $settings->get('pwa_enabled', false);

        $view->with(compact(
            'menus',
            'footerMenus',
            'socialLinks',
            'addresses',
            'settings',
            'pwaEnabled',
        ));
    }
}
