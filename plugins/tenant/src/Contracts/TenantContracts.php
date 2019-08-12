<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-11
 * Time: 19:45
 */

namespace Plugins\Tenant\Contracts;


interface TenantContracts
{
    /**
     * @deprecated
     */
    const DEFAULT_MIGRATION_NAME = 'tenant-migration';

    const DIVISION_MODE_SEPARATE_DATABASE = 'database';
    const DIVISION_MODE_SEPARATE_PREFIX = 'prefix';

    /**
     * Allows division by schema. Postgres only.
     */
    const DIVISION_MODE_SEPARATE_SCHEMA = 'schema';

    /**
     * Allows manually setting the configuration during event callbacks.
     */
    const DIVISION_MODE_BYPASS = 'bypass';
}