<?php

namespace App\Providers;

use App\Repositories\Employee\EmpOrderRepository;
use App\Repositories\Employee\EmpOrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class EmpOrderServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
//    protected $defer = true;
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
        $this->app->bind(EmpOrderRepositoryInterface::class, EmpOrderRepository::class);
    }
}
