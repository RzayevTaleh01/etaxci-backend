<?php

namespace App\Providers;

use App\Models\MenuItem;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Spatie\Translatable\Facades\Translatable;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();

        Translatable::fallback(fallbackLocale: config('app.fallback_locale'));

        // Menus are shared with the public layout.
        View::composer('site.layouts.app', function ($view) {
            try {
                $load = fn (string $location) => MenuItem::active()
                    ->where('location', $location)->whereNull('parent_id')
                    ->with('children')->orderBy('sort')->orderBy('id')->get();

                $view->with('headerMenu', $load('header'))->with('footerMenu', $load('footer'));
            } catch (\Throwable) {
                $view->with('headerMenu', collect())->with('footerMenu', collect());
            }
        });
    }
}
