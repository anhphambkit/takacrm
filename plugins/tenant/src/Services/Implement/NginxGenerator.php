<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-12
 * Time: 10:47
 */

namespace Plugins\Tenant\Services\Implement;

use Plugins\Tenant\Models\Tenant;
use Plugins\Tenant\Services\VhostGenerator;
use Symfony\Component\Process\Process;

class NginxGenerator implements VhostGenerator
{
    /**
     * @param Tenant $tenant
     * @return string
     */
    public function generate(Tenant $tenant): string
    {
        return view(config('plugins-tenant.webserver.nginx.view'), [
            'tenant' => $tenant,
            'config' => config('plugins-tenant.webserver.nginx', []),
            'media' => null
        ]);
    }

    /**
     * @param Tenant $tenant
     * @return string
     */
    public function targetPath(Tenant $tenant): string
    {
        $basePathVhost = config('plugins-tenant.webserver.nginx.paths.vhost-files');
        return "{$basePathVhost}{$tenant->db_name}.conf";
    }

    /**
     * @return bool
     */
    public function reload(): bool
    {
        if ($this->testConfiguration() && $reload = config('plugins-tenant.webserver.nginx.paths.actions.reload')) {
            return (new Process($reload, base_path()))
                ->mustRun()
                ->isSuccessful();
        }

        return false;
    }

    /**
     * @return bool
     */
    public function testConfiguration(): bool
    {
        $test = config('plugins-tenant.webserver.nginx.paths.actions.test-config');

        if (is_bool($test)) {
            return $test;
        }

        return (new Process($test, base_path()))
            ->mustRun()
            ->isSuccessful();
    }
}
