<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
    \App\Repositories\OrderStatisticsRepository::class
);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
       Carbon::setLocale('id');
    }
}
