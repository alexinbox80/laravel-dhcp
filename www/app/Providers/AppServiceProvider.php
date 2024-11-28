<?php

namespace App\Providers;


use App\Services\Contracts\HostContract;
use App\Services\Contracts\IndexContract;
use App\Services\Contracts\ResponseContract;
use App\Services\Contracts\SubnetContract;
use App\Services\HostService;
use App\Services\IndexService;
use App\Services\Response\ResponseService;
use App\Services\SubnetService;
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
        $this->app->bind(SubnetContract::class, SubnetService::class);
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
