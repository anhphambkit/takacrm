<?php

namespace Plugins\Customer\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Customer\Repositories\Caches\CacheCustomerContactRepositories;
use Plugins\Customer\Repositories\Caches\CacheCustomerQueryListRepositories;
use Plugins\Customer\Repositories\Caches\CacheCustomerRelationRepositories;
use Plugins\Customer\Repositories\Caches\CacheCustomerRepositories;
use Plugins\Customer\Repositories\Caches\CacheCustomerSourceRepositories;
use Plugins\Customer\Repositories\Caches\CacheCustomerJobRepositories;
use Plugins\Customer\Repositories\Caches\CacheGroupCustomerRepositories;
use Plugins\Customer\Repositories\Eloquent\EloquentCustomerContactRepositories;
use Plugins\Customer\Repositories\Eloquent\EloquentCustomerQueryListRepositories;
use Plugins\Customer\Repositories\Eloquent\EloquentCustomerRelationRepositories;
use Plugins\Customer\Repositories\Eloquent\EloquentCustomerRepositories;
use Plugins\Customer\Repositories\Eloquent\EloquentCustomerSourceRepositories;
use Plugins\Customer\Repositories\Eloquent\EloquentCustomerJobRepositories;
use Plugins\Customer\Repositories\Eloquent\EloquentGroupCustomerRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerContactRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerQueryListRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerRelationRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;
use Plugins\Customer\Middlewares\RedirectIfNotCustomer;
use Plugins\Customer\Middlewares\RedirectIfCustomer;
use Plugins\Customer\Models\Customer;
use Plugins\Customer\Repositories\Interfaces\CustomerSourceRepositories;
use Plugins\Customer\Repositories\Interfaces\CustomerJobRepositories;
use Plugins\Customer\Repositories\Interfaces\GroupCustomerRepositories;
use Plugins\Customer\Services\CustomerServices;
use Plugins\Customer\Services\Implement\ImplementCustomerServices;

class CustomerServiceProvider extends ServiceProvider
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
        config([
            'auth.guards.customer'     => [
                'driver'   => 'session',
                'provider' => 'customers',
            ],
            'auth.providers.customers' => [
                'driver' => 'eloquent',
                'model'  => Customer::class,
            ],
            'auth.passwords.customers' => [
                'provider' => 'customers',
                'table'    => 'customers_password_resets',
                'expire'   => 60,
            ],
            'auth.guards.member-api' => [
                'driver'   => 'passport',
                'provider' => 'customers',
            ],
        ]);

        /**
         * @var Router $router
         */
        $router = $this->app['router'];

        $router->aliasMiddleware('customer', RedirectIfNotCustomer::class);
        $router->aliasMiddleware('customer.guest', RedirectIfCustomer::class);


        if (setting('enable_cache', false)) {
            $this->app->singleton(CustomerRepositories::class, function () {
                return new CacheCustomerRepositories(new EloquentCustomerRepositories(new \Plugins\Customer\Models\Customer()));
            });

            $this->app->singleton(GroupCustomerRepositories::class, function () {
                return new CacheGroupCustomerRepositories(new EloquentGroupCustomerRepositories(new \Plugins\Customer\Models\GroupCustomer()));
            });

            $this->app->singleton(CustomerSourceRepositories::class, function () {
                return new CacheCustomerSourceRepositories(new EloquentCustomerSourceRepositories(new \Plugins\Customer\Models\CustomerSource()));
            });

            $this->app->singleton(CustomerJobRepositories::class, function () {
                return new CacheCustomerJobRepositories(new EloquentCustomerJobRepositories(new \Plugins\Customer\Models\CustomerJob()));
            });

            $this->app->singleton(CustomerRelationRepositories::class, function () {
                return new CacheCustomerRelationRepositories(new EloquentCustomerRelationRepositories(new \Plugins\Customer\Models\CustomerRelation()));
            });

            $this->app->singleton(CustomerQueryListRepositories::class, function () {
                return new CacheCustomerQueryListRepositories(new EloquentCustomerQueryListRepositories(new \Plugins\Customer\Models\CustomerQueryList()));
            });

            $this->app->singleton(CustomerContactRepositories::class, function () {
                return new CacheCustomerContactRepositories(new EloquentCustomerContactRepositories(new \Plugins\Customer\Models\CustomerContact()));
            });
        } else {
            $this->app->singleton(CustomerRepositories::class, function () {
                return new EloquentCustomerRepositories(new \Plugins\Customer\Models\Customer());
            });

            $this->app->singleton(GroupCustomerRepositories::class, function () {
                return new EloquentGroupCustomerRepositories(new \Plugins\Customer\Models\GroupCustomer());
            });

            $this->app->singleton(CustomerSourceRepositories::class, function () {
                return new EloquentCustomerSourceRepositories(new \Plugins\Customer\Models\CustomerSource());
            });

            $this->app->singleton(CustomerJobRepositories::class, function () {
                return new EloquentCustomerJobRepositories(new \Plugins\Customer\Models\CustomerJob());
            });

            $this->app->singleton(CustomerRelationRepositories::class, function () {
                return new EloquentCustomerRelationRepositories(new \Plugins\Customer\Models\CustomerRelation());
            });

            $this->app->singleton(CustomerQueryListRepositories::class, function () {
                return new EloquentCustomerQueryListRepositories(new \Plugins\Customer\Models\CustomerQueryList());
            });

            $this->app->singleton(CustomerContactRepositories::class, function () {
                return new EloquentCustomerContactRepositories(new \Plugins\Customer\Models\CustomerContact());
            });
        }

        $this->app->singleton(CustomerServices::class, ImplementCustomerServices::class);
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
