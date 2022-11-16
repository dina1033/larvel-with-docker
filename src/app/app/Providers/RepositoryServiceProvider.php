<?php

namespace App\Providers;

use App\Repository\BaseRepository;
use App\Repository\EloquentRepositoryInterface;
use App\Repository\TransectionRepository;
use App\Repository\TransectionRepositoryInterface;
use App\Repository\UserRepository;
use App\Repository\UserRepositoryInterface;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(TransectionRepositoryInterface::class, TransectionRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

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
