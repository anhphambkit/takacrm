<?php

namespace Plugins\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Order\Repositories\Caches\CacheOrderRepositories;
use Plugins\Order\Repositories\Eloquent\EloquentOrderRepositories;
use Plugins\Order\Repositories\Interfaces\OrderRepositories;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author TrinhLe
     */
    public function register()
    {
        if (setting('enable_cache', false)) {
            $this->app->singleton(OrderRepositories::class, function () {
                return new CacheOrderRepositories(new EloquentOrderRepositories(new \Plugins\Order\Models\Order()));
            });
        } else {
            $this->app->singleton(OrderRepositories::class, function () {
                return new EloquentOrderRepositories(new \Plugins\Order\Models\Order());
            });
        }
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
