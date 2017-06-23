<?php

namespace App\Providers;

use App\Repositories\Goods\GoodsRepository;
use App\Repositories\Goods\GoodsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class GoodsServiceProvider extends ServiceProvider
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
        $this->app->bind(GoodsRepositoryInterface::class, GoodsRepository::class);
    }
}
