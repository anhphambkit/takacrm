<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-08
 * Time: 16:01
 */

namespace Plugins\Tenant\Services\Implement;

use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Core\User\Models\User;
use Plugins\Tenant\Repositories\Interfaces\TenantRepositories;
use Plugins\Tenant\Services\DatabaseConnection;
use Plugins\Tenant\Services\TenantServices;
use Plugins\Tenant\Traits\DatabaseConnectionTrait;

class ImplementTenantServices implements TenantServices
{
    /**
     * @var TenantRepositories
     */
    protected $tenantRepositories;

    /**
     * @var DatabaseConnection
     */
    protected $databaseConnection;

    /**
     * ImplementTenantServices constructor.
     * @param TenantRepositories $tenantRepositories
     * @param DatabaseConnection $databaseConnection
     */
    public function __construct(TenantRepositories $tenantRepositories, DatabaseConnection $databaseConnection){
        $this->tenantRepositories = $tenantRepositories;
        $this->databaseConnection = $databaseConnection;
    }

    /**
     * @param array $data
     * @return mixed|void
     */
    public function registerTenant(array $data)
    {
        $tenant = DB::transaction(function () use ($data) {
            $baseUrl = config('plugins-tenant.tenant.tenant_default_hostname');
            $portalName = strtolower(str_slug($data['host_name'], "_"));
            $dataTenant = [
                'host_name' => $data['host_name'],
                'db_name' => $portalName,
//                'db_ip' => $data['host_name'],
//                'db_port' => $data['host_name'],
                'managed_by_database_connection' => $this->databaseConnection->systemName(),
                'fqdn' => "{$portalName}.{$baseUrl}",
                'redirect_to' => $data['redirect_to'],
                'force_https' => !empty($data['force_https']) ? $data['force_https'] : false,
//                'under_maintenance_since' => $data['host_name'],
            ];

            $tenant = $this->tenantRepositories->createOrUpdate($dataTenant);

            return $tenant;

        }, 3);

        $this->databaseConnection->createAndMigrateNewTenantDatabase($tenant);
        $adminData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
        ];
        $this->databaseConnection->makeAdminTenant($adminData);
    }

    /**
     * @param $name
     * @return mixed
     */
    public static function tenantExists($name)
    {
        $name = $name . '.' . config('Tenant.hostname.default');
//        return Hostname::where('fqdn', $name)->exists();
    }
}