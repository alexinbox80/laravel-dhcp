<?php

namespace App\Providers;


use App\Services\Contracts\HostContract;
use App\Services\Contracts\IndexContract;
use App\Services\Contracts\ResponseContract;
use App\Services\HostService;
use App\Services\IndexService;
use App\Services\Response\ResponseService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ResponseContract::class, ResponseService::class);

        //Services
        $this->app->bind(HostContract::class, HostService::class);
        $this->app->bind(IndexContract::class, IndexService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Paginator::defaultSimpleView('vendor.pagination.default');
        Paginator::useBootstrap();
    }
}
