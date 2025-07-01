<?php

namespace App\Providers;

use App\Repositories\CarRepository;
use App\Repositories\EmployeeRepository;
use App\Services\AvailableCarService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Put your bindings here
        $this->app->bind(AvailableCarService::class);
        $this->app->bind(CarRepository::class);
        $this->app->bind(EmployeeRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
