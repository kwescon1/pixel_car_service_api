<?php

namespace App\Providers;

use App\Interfaces\Auth\AuthServiceInterface;
use Illuminate\Support\ServiceProvider;
use App\Services\ServiceType\ServiceType;
use App\Interfaces\ServiceType\ServiceTypeInterface;
use App\Services\Auth\AuthService;
use Illuminate\Contracts\Support\DeferrableProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {


        $this->app->bind(ServiceTypeInterface::class, ServiceType::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
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
        return [ServiceTypeInterface::class, AuthServiceInterface::class,];
    }
}
