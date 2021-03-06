<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        //console api
        if('console' == env('APP_NAME') || "local" == env('APP_ENV')) {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/admin.php'));
        }

        //cashier sys api
        if('shop' == env('APP_NAME') || "local" == env('APP_ENV')) {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/shop.php'));
        }

        //cashier sys api
        if('emp' == env('APP_NAME') || "local" == env('APP_ENV')) {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/employee.php'));
        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
