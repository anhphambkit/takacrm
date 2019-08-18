<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-11
 * Time: 20:40
 */

namespace Plugins\Tenant\Services\Implement;

use Carbon\Carbon;
use Core\User\AclManager;
use Core\User\Models\Activation;
use Core\User\Models\User;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Plugins\Tenancy\Events;
use Plugins\Tenant\Contracts\TenantContracts;
use Plugins\Tenant\Models\Tenant;
use Plugins\Tenant\Services\DatabaseConnection;
use Plugins\Tenant\Services\DatabaseGenerator;
use Symfony\Component\Process\Process;

class ImplementDatabaseConnection implements DatabaseConnection
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * @var Dispatcher
     */
    protected $events;
    /**
     * @var ConnectionResolverInterface
     */
    protected $connection;
    /**
     * @var DatabaseManager
     */
    protected $db;
    /**
     * @var Kernel
     */
    protected $artisan;

    /**
     * Connection constructor.
     * @param Config $config
     * @param DatabaseManager $db
     * @param Kernel $artisan
     */
    public function __construct(
        Config $config,
        DatabaseManager $db,
        Kernel $artisan
    ) {
        $this->config = $config;
        $this->db = $db;
        $this->artisan = $artisan;
    }

    /**
     * @param string|null $connectionName
     * @return \Illuminate\Database\Connection
     */
    public function connectToDBByConnectionName(string $connectionName = null): \Illuminate\Database\Connection
    {
        $connectionName = !empty($connectionName) ? $connectionName : $this->systemName();
        return $this->db->connection($connectionName);
    }

    /**
     * Purges the current tenant connection.
     * @param null $connection
     */
    public function purge($connection = null)
    {
        $connection = $connection ?? $this->tenantName();

        $this->db->purge(
            $connection
        );

        $this->config->set(
            sprintf('database.connections.%s', $connection),
            []
        );
    }

    /**
     * @return string
     */
    public function systemName(): string
    {
        return config('tenant.db.system-connection-name');
    }

    /**
     * @return string
     */
    public function tenantName(): string
    {
        return config('tenant.db.tenant-connection-name');
    }

    /**
     * @param $tenant
     * @return array
     */
    public function generateConfigurationArray($tenant): array {
        $clone = config(sprintf(
            'database.connections.%s',
            $tenant->managed_by_database_connection ?? $this->systemName()
        ));

        $mode = config('tenant.db.tenant-division-mode');
        $prefixTenant = config('tenant.db.database_tenant_prefix');

        switch ($mode) {
            case TenantContracts::DIVISION_MODE_SEPARATE_DATABASE:
                $clone['database'] = "{$prefixTenant}{$tenant->db_name}";
                break;
            case TenantContracts::DIVISION_MODE_SEPARATE_PREFIX:
                $clone['prefix'] = sprintf('%d_', $tenant->id);
                break;
            case TenantContracts::DIVISION_MODE_SEPARATE_SCHEMA:
                $clone['schema'] = "{$prefixTenant}{$tenant->db_name}";
                break;
            case TenantContracts::DIVISION_MODE_BYPASS:
                break;
            default:
                $clone['database'] = "{$prefixTenant}{$tenant->db_name}";
                break;
        }

        return $clone;
    }

    /**
     * @return array
     */
    private function drivers()
    {
        $isPgsqlSchema = config('tenant.db.tenant-division-mode') === TenantContracts::DIVISION_MODE_SEPARATE_SCHEMA;

        return collect([
            'pgsql' => $isPgsqlSchema ? null : PostgreSQL::class,
            'mysql' => null,
        ]);
    }

    /**
     * @param string $driver
     * @return DatabaseGenerator
     * @throws \Exception
     */
    public function getDatabaseInstanceByDriver($driver = 'pgsql') : DatabaseGenerator
    {
        $drivers = $this->drivers();

        if (!in_array($driver, $drivers->keys()->toArray())) {
            throw new \Exception("Could not generate database for driver $driver");
        }

        return new $drivers[$driver]();
    }

    /**
     * @param string|null $connectionName
     */
    public function updateCurrentDatabaseConnection(string $connectionName = null) {
        $connectionName = $connectionName ?? $this->systemName();
        $this->config->set(
            'core-base.cms.current_database_connection',
            $connectionName
        );
    }

    /**
     * @param Tenant $tenant
     * @param string|null $connectionName
     * @return mixed|void
     * @throws \Exception
     */
    public function createAndMigrateNewTenantDatabase(Tenant $tenant, string $connectionName = null) {
        $connectionName = $connectionName ?? $this->tenantName();
        $this->updateCurrentDatabaseConnection($connectionName);
        $configDatabase = update_configuration_connection_tenant($tenant, $connectionName);
        $databaseDriver = $this->getDatabaseInstanceByDriver($configDatabase['driver']);
        $databaseDriver->createDatabaseByConfig($configDatabase, $this->systemName(), $this);
        $this->connectToDBByConnectionName($connectionName);

        // Install/migrate tenant
        $this->artisan->call('tenant:install', [
            'tenant_id' => $tenant->id,
            'connection' => $connectionName,
        ]);

        $this->updateCurrentDatabaseConnection();
        $this->connectToDBByConnectionName();
    }

    /**
     * @param array $data
     * @return int|mixed
     */
    public function makeAdminTenant(array $data) {
        $dbExt = $this->connectToDBByConnectionName($this->tenantName());
        $userId = $dbExt->table(app(User::class)->getTable())->insertGetId($data);
        $now = Carbon::now();$activation = $dbExt->table(app(Activation::class)->getTable())->insert([
            'user_id' => $userId,
            'code' => Str::uuid()->toString(),
            'completed' => true,
            'completed_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        return $userId;
    }
}
