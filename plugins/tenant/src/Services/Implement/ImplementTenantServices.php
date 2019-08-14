<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-08
 * Time: 16:01
 */

namespace Plugins\Tenant\Services\Implement;

use App\Http\Kernel;
use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Core\User\Models\User;
use Plugins\Tenant\Models\Tenant;
use Plugins\Tenant\Repositories\Interfaces\TenantRepositories;
use Plugins\Tenant\Services\DatabaseConnection;
use Plugins\Tenant\Services\ServerServices;
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
     * @var ServerServices
     */
    protected $serverServices;
    protected $artisan;

    /**
     * ImplementTenantServices constructor.
     * @param TenantRepositories $tenantRepositories
     * @param ServerServices $serverServices
     * @param DatabaseConnection $databaseConnection
     * @param Kernel $artisan
     */
    public function __construct(TenantRepositories $tenantRepositories, ServerServices $serverServices,
                                DatabaseConnection $databaseConnection, Kernel $artisan){
        $this->tenantRepositories = $tenantRepositories;
        $this->databaseConnection = $databaseConnection;
        $this->serverServices = $serverServices;
        $this->artisan = $artisan;
    }

    /**
     * @param array $data
     * @return mixed|void
     */
    public function registerTenant(array $data)
    {
        $tenant = DB::transaction(function () use ($data) {
            $baseUrl = config('tenant.tenant_default_hostname');
            $portalName = strtolower(str_slug($data['host_name'], "_"));
            $dataTenant = [
                'host_name' => $data['host_name'],
                'db_name' => $portalName,
//                'db_ip' => $data['host_name'],
//                'db_port' => $data['host_name'],
                'managed_by_database_connection' => !empty($data['managed_by_database_connection']) ? $data['managed_by_database_connection'] : $this->databaseConnection->systemName(),
                'fqdn' => "{$portalName}.{$baseUrl}",
                'redirect_to' => !empty($data['redirect_to']) ? $data['redirect_to'] : null,
                'force_https' => !empty($data['force_https']) ? $data['force_https'] : false,
//                'under_maintenance_since' => $data['host_name'],
            ];

            $tenant = $this->tenantRepositories->createOrUpdate($dataTenant);

            return $tenant;

        }, 3);

        // Create DB for tenant:
        $this->databaseConnection->createAndMigrateNewTenantDatabase($tenant);

        // Create admin login for tenant:
        $adminData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'super_user' => true,
            'manage_supers' => true,
        ];

        $this->databaseConnection->makeAdminTenant($adminData);

        // Create vhost for server tenant:
        $this->serverServices->generate($tenant);
    }

    /**
     * @param array $data
     * @param Tenant $currentTenant
     * @return mixed|void
     */
    public function updateTenant(array $data, Tenant $currentTenant)
    {
        $tenant = DB::transaction(function () use ($data) {
            $baseUrl = config('tenant.tenant_default_hostname');
            $portalName = strtolower(str_slug($data['host_name'], "_"));
            $dataTenant = [
                'host_name' => $data['host_name'],
                'db_name' => $portalName,
//                'db_ip' => $data['host_name'],
//                'db_port' => $data['host_name'],
//                'managed_by_database_connection' => !empty($data['managed_by_database_connection']) ? $data['managed_by_database_connection'] : $this->databaseConnection->systemName(),
                'fqdn' => "{$portalName}.{$baseUrl}",
//                'redirect_to' => !empty($data['redirect_to']) ? $data['redirect_to'] : null,
//                'force_https' => !empty($data['force_https']) ? $data['force_https'] : false,
//                'under_maintenance_since' => $data['host_name'],
            ];

            $tenant = $this->tenantRepositories->createOrUpdate($dataTenant);

            return $tenant;

        }, 3);

        // Create DB for tenant:
        $this->databaseConnection->createAndMigrateNewTenantDatabase($tenant);

        // Create vhost for server tenant:
        $this->serverServices->generate($tenant);
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