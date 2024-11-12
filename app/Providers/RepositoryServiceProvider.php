<?php

namespace App\Providers;

use App\Core\Domain\Repositories\ProductRepositoryInterface;
use App\Core\Domain\Repositories\UserRepositoryInterface;
use App\Core\Infrastructure\Repositories\EloquentProductRepository;
use App\Core\Infrastructure\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, EloquentProductRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
