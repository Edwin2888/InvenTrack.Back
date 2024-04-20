<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Producto\ProductoServicio;
use App\Domain\Producto\IProductoServicio;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductoServicio::class, ProductoServicio::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
