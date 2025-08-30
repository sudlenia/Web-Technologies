<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MenuItem;

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
    public function boot()
    {
        view()->composer('partials.menu', function ($view) {
            $menuItems = MenuItem::where('is_visible', true)->orderBy('order')->get();
            $view->with('menuItems', $menuItems);
        });
    }
}
