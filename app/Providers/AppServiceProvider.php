<?php

namespace App\Providers;

use App\Domain\Jornada\IJornadaServicio;
use App\Domain\Jornada\JornadaServicio;
use Illuminate\Support\ServiceProvider;
use App\Domain\Producto\ProductoServicio;
use App\Domain\Producto\IProductoServicio;
use App\Domain\Registradora\IRegistradoraServicio;
use App\Domain\Registradora\RegistradoraServicio;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductoServicio::class, ProductoServicio::class);
        $this->app->bind(IJornadaServicio::class, JornadaServicio::class);
        $this->app->bind(IRegistradoraServicio::class, RegistradoraServicio::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
