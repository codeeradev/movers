<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\Models\Service;

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
        Schema::defaultStringLength(191);

        View::composer('partials.navbar', function ($view) {
            $navServices = Schema::hasTable('services')
                ? Service::where('status', 1)->orderBy('sort_order')->orderBy('id')->get()
                : collect();

            $view->with('navServices', $navServices);
        });
    }
}
