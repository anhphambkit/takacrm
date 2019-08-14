<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-12
 * Time: 16:13
 */

if (!function_exists('get_sub_domain')) {
    /**
     * @return mixed
     */
    function get_sub_domain()
    {
        $domain        = \request()->getHost();
        $primaryDomain = config('tenant.general.primary_domain');
        $concatDomain  = config('tenant.general.portal_concat_domain');
        $subDomain     = str_replace("{$concatDomain}{$primaryDomain}", "", $domain);

        if ($subDomain === $primaryDomain)
            return null;
        return $subDomain;
    }
}

if (!function_exists('generate_configuration_array')) {
    /**
     * @param $tenant
     * @return array
     */
    function generate_configuration_array($tenant): array {
        $clone = config(sprintf(
            'database.connections.%s',
            $tenant->managed_by_database_connection ?? config('database.default')
        ));

        $mode = config('tenant.db.tenant-division-mode');
        $prefixTenant = config('tenant.db.database_tenant_prefix');

        switch ($mode) {
            case \Plugins\Tenant\Contracts\TenantContracts::DIVISION_MODE_SEPARATE_DATABASE:
                $clone['database'] = "{$prefixTenant}{$tenant->db_name}";
                break;
            case \Plugins\Tenant\Contracts\TenantContracts::DIVISION_MODE_SEPARATE_PREFIX:
                $clone['prefix'] = sprintf('%d_', $tenant->id);
                break;
            case \Plugins\Tenant\Contracts\TenantContracts::DIVISION_MODE_SEPARATE_SCHEMA:
                $clone['schema'] = "{$prefixTenant}{$tenant->db_name}";
                break;
            case \Plugins\Tenant\Contracts\TenantContracts::DIVISION_MODE_BYPASS:
                break;
            default:
                $clone['database'] = "{$prefixTenant}{$tenant->db_name}";
                break;
        }

        return $clone;
    }
}

if (!function_exists('update_configuration_connection_tenant')) {
    /**
     * @param $tenant
     * @param string|null $connectionName
     * @return array
     */
    function update_configuration_connection_tenant($tenant, string $connectionName = null): array {
        $connectionName = $connectionName ?? config('tenant.db.tenant_connection_name');
        $configDatabase = generate_configuration_array($tenant);

        // Sets current connection settings.
        config()->set(
            sprintf('database.connections.%s', $connectionName),
            $configDatabase
        );

        return $configDatabase;
    }
}

if (!function_exists('set_current_database_connection')) {
    /**
     *
     */
    function set_current_database_connection() {
        $subDomain = function_exists('get_sub_domain') ? get_sub_domain() : null;

        if (!empty($subDomain)) {
            $tenant = \Illuminate\Support\Facades\DB::table(config('tenant.system.tenant_table'))->where('db_name', $subDomain)->first();

            if (!empty($tenant)) {
                $connectionName = config('tenant.db.tenant-connection-name');
                update_configuration_connection_tenant($tenant, $connectionName);
                config()->set('database.default', $connectionName);
                \Illuminate\Support\Facades\DB::connection()->reconnect();
                \Core\Master\Supports\Helper::autoloadHelpers();
            }
        }
    }
}