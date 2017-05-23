<?php

namespace App\Providers;

use App\Repositories\Employee\EmployeeRepositoryInterface;
use App\Repositories\Employee\EmployeeRepository;
use Illuminate\Support\ServiceProvider;

class EmployeeServiceProvider extends ServiceProvider
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
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
    }
}
