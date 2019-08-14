<?php

namespace Plugins\Tenancy\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Tenancy\Models\Hostname;
use Plugins\Tenancy\Models\Website;
use Plugins\Tenancy\Repositories\Interfaces\HostnameRepository;
use Plugins\Tenancy\Repositories\Interfaces\WebsiteRepository;
use Plugins\Tenancy\Services\Implement\ImplementTenancyServices;
use Plugins\Tenancy\Services\TenantServices;
use Plugins\Tenancy\Traits\TenancyBoot;

class TenancyServiceProvider extends ServiceProvider
{
    use TenancyBoot;
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
        $this->app->register(WebserverProvider::class);
        $this->app->register(TenancyProvider::class);
        $this->app->register(AuthenticationProvider::class);
        $this->app->singleton(TenantServices::class, ImplementTenancyServices::class);
        register_repositories($this);
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        $this->publishMigrationTenancy();
    }

    /**
     * @return array
     */
    public function getRepositories():array
    {
        return [
            HostnameRepository::class     => Hostname::class,
            WebsiteRepository::class      => Website::class,
        ];
    }
}
