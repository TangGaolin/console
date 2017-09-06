<?php

namespace App\Providers;

use App\Repositories\UserOrderTime\UserOrderTimeRepository;
use App\Repositories\UserOrderTime\UserOrderTimeRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class UserOrderITimeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(UserOrderTimeRepositoryInterface::class, UserOrderTimeRepository::class);
    }
}
