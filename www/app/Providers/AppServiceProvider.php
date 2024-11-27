<?php

namespace App\Providers;


use App\Services\Contracts\Host;
use App\Services\Contracts\Index;
use App\Repository\Contracts\Host as HostRepositoryContract;
use App\Services\HostService;
use App\Services\IndexService;
use App\Repository\HostRepository;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Services
        $this->app->bind(Host::class, HostService::class);
        $this->app->bind(Index::class, IndexService::class);
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
