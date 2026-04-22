<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\WebsiteHero;

class AppServiceProvider extends ServiceProvider
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
        // Load settings from database into config
        if (Schema::hasTable('settings')) {
            $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();
            config(['settings' => $settings]);
        }

        // Share hero data with all views
        View::composer('*', function ($view) {
            if (! $view->offsetExists('hero') && Schema::hasTable('website_hero')) {
                $view->with('hero', WebsiteHero::active()->first());
            }
        });
    }
}
