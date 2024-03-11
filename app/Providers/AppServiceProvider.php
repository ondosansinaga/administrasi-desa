<?php

namespace App\Providers;

use App\Services\Impl\LetterServiceImpl;
use App\Services\Impl\NewsServiceImpl;
use App\Services\Impl\RequestLetterServiceImpl;
use App\Services\Impl\RoleServiceImpl;
use App\Services\Impl\UserServiceImpl;
use App\Services\LetterService;
use App\Services\NewsService;
use App\Services\RequestLetterService;
use App\Services\RoleService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Services\Impl\WargaServiceImpl;
use App\Services\WargaService;

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        UserService::class => UserServiceImpl::class,
        RoleService::class => RoleServiceImpl::class,
        LetterService::class => LetterServiceImpl::class,
        NewsService::class => NewsServiceImpl::class,
        RequestLetterService::class => RequestLetterServiceImpl::class,
        WargaService::class => WargaServiceImpl::class,
    ];

    public function provides(): array
    {
        return [
            UserService::class,
            RoleService::class,
            LetterService::class,
            NewsService::class,
            RequestLetterService::class,
            WargaService::class,
        ];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(WargaService::class, WargaServiceImpl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();
        Carbon::setLocale('id');
    }
}