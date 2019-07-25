<?php

namespace Plugins\Tenancy\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Tenancy\Repositories\Caches\CacheTenancyRepositories;
use Plugins\Tenancy\Repositories\Eloquent\EloquentTenancyRepositories;
use Plugins\Tenancy\Repositories\Interfaces\TenancyRepositories;

class TenancyServiceProvider extends ServiceProvider
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
        $this->app->register(WebserverProvider::class);
        $this->app->register(TenancyProvider::class);
        $this->app->register(AuthenticationProvider::class);
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
