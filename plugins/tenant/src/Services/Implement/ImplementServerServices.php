<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-12
 * Time: 10:38
 */

namespace Plugins\Tenant\Services\Implement;

use Illuminate\Filesystem\FilesystemManager;
use Plugins\Tenancy\Events;
use Plugins\Tenant\Contracts\TenantContracts;
use Plugins\Tenant\Models\Tenant;
use Plugins\Tenant\Services\ServerServices;
use Plugins\Tenant\Services\VhostGenerator;
use Symfony\Component\Process\Process;

class ImplementServerServices implements ServerServices
{
    /**
     * @var FilesystemManager
     */
    protected $filesystemManager;

    public function __construct(FilesystemManager $filesystemManager)
    {
        $this->filesystemManager = $filesystemManager;
    }

    /**
     * @param Tenant $tenant
     * @return bool
     */
    public function generate(Tenant $tenant)
    {
        $serverType = config('plugins-tenant.webserver.use_server_type');

        $serverGeneratorInstance = $this->getInstanceServerByType($serverType);

        if (empty($serverGeneratorInstance))
            return false;

        $contents = $serverGeneratorInstance->generate($tenant);
        $path = $serverGeneratorInstance->targetPath($tenant);

        $diskType = config("plugins-tenant.webserver.{$serverType}.disk");
        $this->writeFileToDisk($path, $contents, $diskType);

        // Update host domain to hosts:
        $this->updateDomainToHosts($tenant);

        if(config('plugins-tenant.webserver.auto_reload_web_server'))
            $serverGeneratorInstance->reload();
    }

    /**
     * @param Tenant $tenant
     */
    private function updateDomainToHosts(Tenant $tenant) {
        (new Process(sprintf('sudo chmod -R 777 %s', config('plugins-tenant.webserver.path_server_hosts'))))
            ->mustRun()
            ->isSuccessful();

        (new Process(sprintf('sudo echo \'%s %s\' >> /etc/hosts',  config('plugins-tenant.webserver.default_localhost_ip'), $tenant->fqdn)))
            ->mustRun()
            ->isSuccessful();

        (new Process(sprintf('sudo chmod -R 644 %s', config('plugins-tenant.webserver.path_server_hosts'))))
            ->mustRun()
            ->isSuccessful();
    }
    /**
     * @param string $serverType
     * @return VhostGenerator
     */
    public function getInstanceServerByType(string $serverType = 'nginx'): VhostGenerator {
        return $serverType === TenantContracts::SERVER_NGINX ? new NginxGenerator() : null;
    }

    /**
     * @param string|null $diskType
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function serviceFilesystem(string $diskType = null)
    {
        return $this->filesystemManager->disk(!empty($diskType) ? $diskType : config('filesystems.default'));
    }

    /**
     * @param string $path
     * @param string $contents
     * @param string|null $diskType
     * @return bool
     */
    protected function writeFileToDisk(string $path, string $contents, string $diskType = null): bool
    {
        $filesystem = $this->serviceFilesystem($diskType);

        if (!$filesystem->exists(dirname($path)) && dirname($path) != '.') {
            $filesystem->makeDirectory(dirname($path));
        }

        return $filesystem->put($path, $contents);
    }
}
