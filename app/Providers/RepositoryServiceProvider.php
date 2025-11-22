<?php

namespace App\Providers;

use App\Interfaces\LoginInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\LoginRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
       $this->app->bind(LoginInterface::class, LoginRepository::class);
       $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
