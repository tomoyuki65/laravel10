<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('App\Services\UserService');
        $this->app->bind('App\Repositories\User\UserRepositoryInterface', 'App\Repositories\User\UserRepository');
        $this->app->bind('App\Services\AuthService');
        $this->app->bind('App\Repositories\Auth\AuthRepositoryInterface', 'App\Repositories\Auth\AuthRepository');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
