<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Rbac\RbacRepositoryInterface;
use App\Repositories\Rbac\RbacRepository;

class RbacRepositoryProvider extends ServiceProvider
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
        $this->app->bind(RbacRepositoryInterface::class, RbacRepository::class);
    }
}
