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

namespace Plugins\Tenant\Services;

interface DatabaseGenerator
{
    /**
     * @param array $config
     * @param string $connectionName
     * @param DatabaseConnection $databaseConnection
     * @return bool
     */
    public function createDatabaseByConfig(array $config, string $connectionName, DatabaseConnection $databaseConnection): bool;
}
