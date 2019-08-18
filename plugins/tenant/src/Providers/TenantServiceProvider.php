<?php

namespace Plugins\Tenant\Providers;

use Core\Master\Supports\LoadRegisterTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Plugins\Tenant\Commands\InstallTenant;
use Plugins\Tenant\Commands\MigrateTenant;
use Plugins\Tenant\Commands\PluginActiveTenant;
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
        $this->publishes([
            __DIR__ . '/../../config/tenant.php' => config_path('tenant.php')
        ], 'tenant-config');

        $this->app->singleton(TenantServices::class, ImplementTenantServices::class);
        $this->app->singleton(DatabaseConnection::class, ImplementDatabaseConnection::class);
        $this->app->singleton(DatabaseGenerator::class);
        $this->app->singleton(VhostGenerator::class);
        $this->app->singleton(ServerServices::class, ImplementServerServices::class);
        register_repositories($this);
        $this->registerValidation();
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        $this->publishMigrationTenancy();
        $this->commands([
            InstallTenant::class,
            PluginActiveTenant::class,
            MigrateTenant::class
        ]);
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
                $tenantPath = config('tenant.db.tenant-connection-name');
                foreach ($tenantSources as $group => $dir) {
                    $this->publishes([
                        $dir => database_path("migrations/{$tenantPath}"),
                    ], "cms-migrations-{$tenantPath}");
                }

                // Publish system migrations:
                $systemSources = $this->loadPackages(SYSTEM_SOURCE_MIGRATIONS);
                $systemPath = config('tenant.db.system-connection-name');
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

    /**
     * Register list extend validation
     * @author TrinhLe
     */
    protected function registerValidation()
    {
        /**
         * Create validation mutiple level
         * @author TrinhLe
         * @return boolean
         */
        Validator::extend('unique_tenant', function ($attribute, $value, $parameters, $validator) {
            $valueFormated  = strtolower(str_slug($value, "_"));
            $dbTable        = $parameters[0] ?? config('tenant.system.tenant_table');
            $columnName     = $parameters[1] ?? $attribute;
            $idRecord       = $parameters[2] ?? null;
            $query = DB::table($dbTable)->where($columnName, $valueFormated);
            if (!empty($idRecord))
                $query = $query->where('id', '<>', $idRecord);
            return !$query->exists();
        });

        /**
         * Replace validation mutiple level
         * @author TrinhLe ['portal' => $portal]
         * @return String
         */
        Validator::replacer('unique_tenant', function ($message, $attribute, $rule, $parameters) {
            return trans('plugins-tenant::tenant.messages.unique_tenant', [ 'attr' => $attribute ]);
        });
    }
}
