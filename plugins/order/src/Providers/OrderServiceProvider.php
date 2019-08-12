<?php

namespace Plugins\Order\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Order\Repositories\Interfaces\OrderRepositories;
use Plugins\Order\Repositories\Interfaces\OrderSourceRepositories;
use Plugins\Order\Repositories\Interfaces\PaymentMethodRepositories;
use Plugins\Order\Repositories\Interfaces\ProductsInOrderRepositories;
use Plugins\Order\Services\Implement\ImplementOrderServices;
use Plugins\Order\Services\Implement\ImplementProductsInOrderServices;
use Plugins\Order\Services\OrderServices;
use Plugins\Order\Services\ProductsInOrderServices;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Prefix support binding eloquent
     * @author TrinhLe
     */
    const PREFIX_REPOSITORY_ELOQUENT = 'Eloquent\\Eloquent';

    /**
     * Prefix support binding cache
     * @author TrinhLe
     */
    const PREFIX_REPOSITORY_CACHE = 'Caches\\Cache';

    /**
     * @author TrinhLe
     */
    public function register()
    {
        register_repositories($this);
        $this->app->singleton(OrderServices::class, ImplementOrderServices::class);
        $this->app->singleton(ProductsInOrderServices::class, ImplementProductsInOrderServices::class);
    }

    /**
     * Get config repositories
     * @author TrinhLe
     * @return [array] [description]
     */
    public function getRepositories():array
    {
        return [
            OrderRepositories::class           => \Plugins\Order\Models\Order::class,
            PaymentMethodRepositories::class => \Plugins\Order\Models\PaymentMethod::class,
            OrderSourceRepositories::class => \Plugins\Order\Models\SourceOrder::class,
            ProductsInOrderRepositories::class => \Plugins\Order\Models\ProductsInOrder::class,
        ];
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
