<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Services\Contracts\TokenInterface::class, \App\Services\Token\JwtService::class);
        $this->app->bind(\App\Services\Contracts\SessionInterface::class, \App\Services\Session\SessionService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
