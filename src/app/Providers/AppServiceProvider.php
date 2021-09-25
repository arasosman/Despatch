<?php

namespace App\Providers;

use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\RequestQueueRepositoryContract;
use App\Repositories\OrderRepository;
use App\Repositories\RequestQueueRepository;
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
        $this->bindService();
        $this->bindRepositories();
    }

    private function bindRepositories()
    {
        $this->app->bind(OrderRepositoryContract::class, OrderRepository::class);
        $this->app->bind(RequestQueueRepositoryContract::class, RequestQueueRepository::class);
    }

    private function bindService()
    {
        $this->app->bind(MarketApiServiceContract::class, MarketApiService::class);
    }
}
