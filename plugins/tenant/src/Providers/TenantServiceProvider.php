<?php

namespace Plugins\Tenant\Providers;

use Core\Master\Supports\LoadRegisterTrait;
use Illuminate\Support\ServiceProvider;
use Plugins\Tenant\Models\Tenant;
use Plugins\Tenant\Repositories\Interfaces\TenantRepositories;
use Plugins\Tenant\Services\DatabaseConnection;
use Plugins\Tenant\Services\DatabaseGenerator;
use Plugins\Tenant\Services\Implement\ImplementDatabaseConnection;
use Plugins\Tenant\Services\Implement\ImplementServerServices;
use Plugins\Tenant\Services\Implement\ImplementTenantServices;
use Plugins\Tenant\Services\ServerServices;
use Plugins\Tenant\Services\TenantServices;
use Plugins\Tenant\Services\VhostGenerator;

class TenantServiceProvider extends ServiceProvider
{
    use LoadRegisterTrait;

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
        $this->app->singleton(TenantServices::class, ImplementTenantServices::class);
        $this->app->singleton(DatabaseConnection::class, ImplementDatabaseConnection::class);
        $this->app->singleton(DatabaseGenerator::class);
        $this->app->singleton(VhostGenerator::class);
        $this->app->singleton(ServerServices::class, ImplementServerServices::class);
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
     * Description
     * @author TrinhLe
     */
    protected function publishMigrationTenancy()
    {
        if (app()->environment() !== 'testing')
        {
            if ($this->app->runningInConsole()) {
                // Publish tenant migrations:
                $tenantSources = $this->loadPackages(TENANT_SOURCE_MIGRATIONS);
                $tenantPath = config('plugins-tenant.tenant.db.tenant-connection-name');
                foreach ($tenantSources as $group => $dir) {
                    $this->publishes([
                        $dir => database_path("migrations/{$tenantPath}"),
                    ], "cms-migrations-{$tenantPath}");
                }

                // Publish system migrations:
                $systemSources = $this->loadPackages(SYSTEM_SOURCE_MIGRATIONS);
                $systemPath = config('plugins-tenant.tenant.db.system-connection-name');
                foreach ($systemSources as $group => $dir) {
                    $this->publishes([
                        $dir => database_path("migrations/{$systemPath}"),
                    ], "cms-migrations-{$systemPath}");
                }
            }
        }
    }

    /**
     * @return array
     */
    public function getRepositories():array
    {
        return [
            TenantRepositories::class => Tenant::class,
        ];
    }
}
