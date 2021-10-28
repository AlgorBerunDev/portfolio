<?php

namespace App\Providers;

use App\Repository\Contracts\EloquentRepositoryInterface;
use App\Repository\Contracts\SessionRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use App\Repository\Eloquent\SessionRepository;
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
        $this->app->bind(SessionRepositoryInterface::class, SessionRepository::class);
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
