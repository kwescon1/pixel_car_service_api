<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthServiceInterface;
use App\Interfaces\CarService\CarServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\ServiceType\ServiceTypeService;
use App\Interfaces\ServiceType\ServiceTypeInterface;
use App\Services\Auth\AuthService;
use App\Services\CarService\CarServiceService;
use Illuminate\Contracts\Support\DeferrableProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {


        $this->app->bind(ServiceTypeInterface::class, ServiceTypeService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(CarServiceInterface::class, CarServiceService::class);
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, string>
     */
    public function provides(): array
    {
        return [ServiceTypeInterface::class, AuthServiceInterface::class, CarServiceInterface::class];
    }
}
