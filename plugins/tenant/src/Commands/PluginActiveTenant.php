<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-13
 * Time: 16:41
 */

namespace Plugins\Tenant\Commands;

use Core\Master\Supports\LoadRegisterTrait;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Core\Base\Repositories\Interfaces\PluginRepositories;
use Illuminate\Support\Facades\Artisan;
use Plugins\Tenant\Repositories\Interfaces\TenantRepositories;
use Plugins\Tenant\Services\DatabaseConnection;

class PluginActiveTenant extends Command
{
    use LoadRegisterTrait;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var PluginRepositories
     */
    protected $pluginRepositories;

    /**
     * @var TenantRepositories
     */
    protected $tenantRepositories;

    /**
     * @var DatabaseConnection
     */
    protected $databaseConnection;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'tenant-plugin:activate {name : The plugin that you want to activate} {tenant_id : id of tenant} {connection? : connection of database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate a plugin in /plugins directory';

    /**
     * PluginActivateCommand constructor.
     * @param Filesystem $files
     * @param TenantRepositories $tenantRepositories
     * @param PluginRepositories $pluginRepositories
     * @param DatabaseConnection $databaseConnection
     */
    public function __construct(Filesystem $files, TenantRepositories $tenantRepositories,
                                PluginRepositories $pluginRepositories, DatabaseConnection $databaseConnection)
    {
        parent::__construct();

        $this->files = $files;
        $this->pluginRepositories = $pluginRepositories;
        $this->tenantRepositories = $tenantRepositories;
        $this->databaseConnection = $databaseConnection;
    }

    /**
     * @throws Exception
     * @return boolean
     * @author TrinhLe
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');
        $plugin = $this->argument('name');

        $pluginFolder = ucfirst(strtolower($plugin));
        $location = config('core-base.cms.plugin_path') . '/' . strtolower($pluginFolder);

        if (!$this->files->isDirectory($location)) {
            $this->error('This plugin is not exists.');
            return false;
        }

        $content = get_file_data($location . '/plugin.json');
        if (!empty($content)) {

            $namespace = str_replace('\\Plugin', '\\', $content['plugin']);
            $composer = get_file_data(base_path() . '/composer.json');

            if (!empty($composer) && !isset($composer['autoload']['psr-4'][$namespace])) {
                $composer['autoload']['psr-4'][$namespace] = 'plugins/' . strtolower($pluginFolder) . '/src';
                save_file_data(base_path() . '/composer.json', $composer);
                Artisan::call('dump-autoload');
            }

            $tenant = $this->tenantRepositories->findById($tenantId);

            $connectionName = $connectionName ?? $this->databaseConnection->tenantName();

            update_configuration_connection_tenant($tenant, $connectionName);
            $dbExt = $this->databaseConnection->connectToDBByConnectionName($connectionName);
            $tableName = app(PluginRepositories::class)->getTable();

            $plugin = $dbExt->table("{$tableName}")
                ->where('provider', $content['provider'])
                ->first();

            if (empty($plugin) || $plugin->status != 1) {
                if (empty($plugin)) {
                    $dataPlugin = $content;
                    unset($dataPlugin['plugin']);
                    $dbExt->table($tableName)->insert($dataPlugin);
                }
                $dataPlugin['alias'] = strtolower($pluginFolder);
                $dataPlugin['status'] = 1;

                call_user_func([$content['plugin'], 'activate'], $connectionName);

                $dbExt->table($tableName)
                        ->where('provider', $content['provider'])
                        ->update($dataPlugin);
                $this->flushAllCacheProvider();
            }
            $this->info("AAAAAA");
            call_user_func([$content['plugin'], 'activate'], $connectionName);
        }
        return true;
    }
}
