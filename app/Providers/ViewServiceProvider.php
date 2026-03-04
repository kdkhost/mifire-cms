<?php

namespace App\Providers;

use App\Http\ViewComposers\SiteComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share common data with all site.* views
        View::composer('site.*', SiteComposer::class);

        // Share unread contacts count with all admin views
        View::composer('admin.*', function ($view) {
            $view->with('unread_contacts_count', \App\Models\Contact::unread()->count());
        });
    }
}
