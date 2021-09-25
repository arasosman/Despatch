<?php

namespace App\Providers;

use App\Services\Contracts\MarketApiServiceContract;
use App\Services\MarketApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(MarketApiServiceContract::class, MarketApiService::class);
    }
}
