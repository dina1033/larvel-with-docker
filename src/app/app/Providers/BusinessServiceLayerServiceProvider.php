<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Service\{BaseService,TransectionService,UserService};
use App\Service\{ServiceInterface, TransectionServiceInterface, UserServiceInterface};


class BusinessServiceLayerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ServiceInterface::class, BaseService::class);
        $this->app->bind(TransectionServiceInterface::class, TransectionService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
