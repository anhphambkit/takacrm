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

namespace Plugins\Tenancy\Providers\Tenants;

use Plugins\Tenancy\Database\Connection;
use Plugins\Tenancy\Generators\Webserver\Database\DatabaseDriverFactory;
use Plugins\Tenancy\Generators\Webserver\Database\Drivers\MariaDB;
use Plugins\Tenancy\Generators\Webserver\Database\Drivers\PostgreSQL;
use Plugins\Tenancy\Generators\Webserver\Database\Drivers\PostgresSchema;
use Illuminate\Support\ServiceProvider;

class DatabaseDriverProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('tenancy.db.drivers', function () {
            return collect($this->drivers());
        });
        
        $this->app->singleton(DatabaseDriverFactory::class);
    }

    private function drivers()
    {
        $isPgsqlSchema = config('tenancy.db.tenant-division-mode') === Connection::DIVISION_MODE_SEPARATE_SCHEMA;
        
        return [
            'pgsql' => $isPgsqlSchema ? PostgresSchema::class : PostgreSQL::class,
            'mysql' => MariaDB::class,
        ];
    }
}
