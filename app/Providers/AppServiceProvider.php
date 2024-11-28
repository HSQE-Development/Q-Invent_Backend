<?php

namespace App\Providers;

use App\Core\Domain\Services\AuthServiceInterface;
use App\Core\Domain\Services\ExcelReaderServiceInterface;
use App\Core\Domain\Services\PasswordHasherInterface;
use App\Core\Infrastructure\Services\AuthService;
use App\Core\Infrastructure\Services\ExcelReaderService;
use App\Core\Infrastructure\Services\PasswordHasher;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(PasswordHasherInterface::class, PasswordHasher::class);
        $this->app->bind(ExcelReaderServiceInterface::class, ExcelReaderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
