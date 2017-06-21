<?php

namespace App\Providers;

use App\Repositories\Item\ItemRepository;
use App\Repositories\Item\ItemRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class ItemServiceProvider extends ServiceProvider
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
        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);
    }
}
