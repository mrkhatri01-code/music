<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Fix public path for production environments (like Hostinger)
        if (strpos(base_path(), 'public_html') !== false) {
            $this->app->bind('path.public', function () {
                return base_path();
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::useBootstrapFive();

        try {
            $siteName = \App\Models\SiteSetting::get('site_name') ?: config('app.name', 'Nepali Lyrics');
            $siteLogo = \App\Models\SiteSetting::get('site_logo');

            \Illuminate\Support\Facades\View::share('siteName', $siteName);
            \Illuminate\Support\Facades\View::share('siteLogo', $siteLogo);
        } catch (\Exception $e) {
            // Fallback if database or table not found (e.g. during migration)
            \Illuminate\Support\Facades\View::share('siteName', config('app.name', 'Nepali Lyrics'));
            \Illuminate\Support\Facades\View::share('siteLogo', null);
        }
    }
}
