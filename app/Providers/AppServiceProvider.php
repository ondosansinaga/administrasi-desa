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

class AppServiceProvider extends ServiceProvider
{
    public array $singletons = [
        UserService::class => UserServiceImpl::class,
        RoleService::class => RoleServiceImpl::class,
        LetterService::class => LetterServiceImpl::class,
        NewsService::class => NewsServiceImpl::class,
        RequestLetterService::class => RequestLetterServiceImpl::class,
    ];

    public function provides(): array
    {
        return [
            UserService::class,
            RoleService::class,
            LetterService::class,
            NewsService::class,
            RequestLetterService::class,
        ];
    }

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
        Paginator::useBootstrap();
        Carbon::setLocale('id');
    }
}