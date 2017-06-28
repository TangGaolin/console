<?php

namespace App\Providers;

use App\Repositories\Users\UsersRepository;
use App\Repositories\Users\UsersRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class UsersServiceProvider extends ServiceProvider
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
        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);
    }
}
