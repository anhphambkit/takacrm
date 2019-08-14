<?php

/*
 * This file is part of the hyn/multi-tenant package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://laravel-tenancy.com
 * @see https://github.com/hyn/multi-tenant
 */

namespace Plugins\Tenant\Services\Implement;

use Illuminate\Database\Connection as IlluminateConnection;
use Plugins\Tenant\Services\DatabaseConnection;
use Plugins\Tenant\Services\DatabaseGenerator;

class PostgreSQL implements DatabaseGenerator
{
    /**
     * @param array $config
     * @param string $connectionName
     * @param DatabaseConnection $databaseConnection
     * @return bool
     */
    public function createDatabaseByConfig(array $config, string $connectionName, DatabaseConnection $databaseConnection): bool
    {
        $connection = $databaseConnection->connectToDBByConnectionName($connectionName);

        $createUser = config('tenant.db.auto-create-tenant-database-user');

        if ($createUser) {
            return
                $this->createUser($connection, $config) &&
                $this->createDatabase($connection, $config) &&
                $this->grantPrivileges($connection, $config);
        } else {
            return $this->createDatabase($connection, $config);
        }
    }

    protected function createUser(IlluminateConnection $connection, array $config)
    {
        if (!$this->userExists($connection, $config['username'])) {
            return $connection->statement("CREATE USER \"{$config['username']}\" WITH PASSWORD '{$config['password']}'");
        }

        return true;
    }

    protected function createDatabase(IlluminateConnection $connection, array $config)
    {
        return $connection->statement("CREATE DATABASE \"{$config['database']}\"");
    }

    protected function grantPrivileges(IlluminateConnection $connection, array $config)
    {
        return $connection->statement("GRANT ALL PRIVILEGES ON DATABASE \"{$config['database']}\" TO \"{$config['username']}\"");
    }

    protected function userExists($connection, string $username): bool
    {
        return $connection->table('pg_roles')
                ->where('rolname', $username)
                ->count() > 0;
    }

    protected function flushConnection(IlluminateConnection $connection, array $config)
    {
        $connection
            ->table('pg_stat_activity')
            ->select($connection->raw('pg_terminate_backend(pid)'))
            ->where('datname', $config['database'])
            ->where('pid', '<>', $connection->raw('pg_backend_pid()'))
            ->get();

        return true;
    }

    protected function dropPriviliges(IlluminateConnection $connection, array $config)
    {
        if ($this->userExists($connection, $config['username'])) {
            return $connection->statement("DROP OWNED BY \"{$config['username']}\"");
        }

        return true;
    }

    protected function dropDatabase(IlluminateConnection $connection, array $config)
    {
        return $connection->statement("DROP DATABASE IF EXISTS \"{$config['database']}\"");
    }

    protected function dropUser(IlluminateConnection $connection, array $config)
    {
        if (config('tenancy.db.auto-delete-tenant-database-user') && $this->userExists($connection,
                $config['username'])) {
            return $connection->statement("DROP USER \"{$config['username']}\"");
        }

        return true;
    }
}
