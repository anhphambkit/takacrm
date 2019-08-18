<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-18
 * Time: 10:32
 */

namespace Plugins\Tenant\Commands;
use Illuminate\Console\Command;
use Plugins\Tenant\Repositories\Interfaces\TenantRepositories;
use Plugins\Tenant\Services\DatabaseConnection;
use Illuminate\Support\Facades\Log;

class MigrateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:migrate {tenant_id : id of tenant} {path? : path of migration database} {connection? : connection of database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Tenant] Migrate data.';

    /**
     * @var TenantRepositories
     */
    protected $tenantRepositories;

    /**
     * @var DatabaseConnection
     */
    protected $databaseConnection;

    /**
     * MigrateTenant constructor.
     * @param TenantRepositories $tenantRepositories
     * @param DatabaseConnection $databaseConnection
     */
    public function __construct(TenantRepositories $tenantRepositories, DatabaseConnection $databaseConnection)
    {
        parent::__construct();
        $this->tenantRepositories = $tenantRepositories;
        $this->databaseConnection = $databaseConnection;
    }

    /**
     * Execute the console command.
     * $dir => database_path('migrations')
     * @return mixed
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        $path = $this->argument('path');
        $connectionName = $this->argument('connection');

        $tenant = $this->tenantRepositories->findById($tenantId);

        $connectionName = $connectionName ?? $this->databaseConnection->tenantName();

        update_configuration_connection_tenant($tenant, $connectionName);
        $this->databaseConnection->connectToDBByConnectionName($connectionName);

        $this->call('vendor:publish', [
            '--tag' => 'cms-migrations',
            '--force' => true
        ]);

        $this->call('migrate', [
            '--force' => true,
            '--database' => $connectionName
        ]);

        if (!empty($path)) {
            $migrationPath = "database/migrations/{$path}";

            $this->call('vendor:publish', [
                '--tag' => "cms-migrations-{$path}",
                '--force' => true
            ]);

            $this->call('migrate', [
                '--path' => $migrationPath,
                '--database' => $connectionName,
                '--force' => true,
            ]);
        }
    }
}