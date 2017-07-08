<?php

namespace App\Providers;

use App\Repositories\Users\UsersAccountRepository;
use App\Repositories\Users\UsersAccountRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class UsersAccountServiceProvider extends ServiceProvider
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
        $this->app->bind(UsersAccountRepositoryInterface::class, UsersAccountRepository::class);
    }
}
