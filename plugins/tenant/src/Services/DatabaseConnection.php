<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-11
 * Time: 20:39
 */

namespace Plugins\Tenant\Services;

use Plugins\Tenant\Models\Tenant;

interface DatabaseConnection
{
    /**
     * @param string|null $connectionName
     * @return \Illuminate\Database\Connection$connectionName
     */
    public function connectToDBByConnectionName(string $connectionName = null): \Illuminate\Database\Connection;

    /**
     * Purges the current tenant connection.
     * @param null $connection
     */
    public function purge($connection = null);

    /**
     * @return string
     */
    public function systemName(): string;

    /**
     * @return string
     */
    public function tenantName(): string;

    /**
     * @param Tenant $tenant
     * @param null $connectionName
     * @return array
     */
    public function updateConfigurationConnectionTenant(Tenant $tenant, $connectionName = null): array;

    /**
     * @param Tenant $tenant
     * @return array
     */
    public function generateConfigurationArray(Tenant $tenant): array;

    /**
     * @param string $driver
     * @return DatabaseGenerator
     * @throws \Exception
     */
    public function getDatabaseInstanceByDriver($driver = 'pgsql') : DatabaseGenerator;

    /**
     * @param Tenant $tenant
     * @param string|null $connectionName
     * @return mixed
     */
    public function createAndMigrateNewTenantDatabase(Tenant $tenant, string $connectionName = null);

    /**
     * @param array $data
     * @return mixed
     */
    public function makeAdminTenant(array $data);

    /**
     * @param string|null $connectionName
     */
    public function updateCurrentDatabaseConnection(string $connectionName = null);
}