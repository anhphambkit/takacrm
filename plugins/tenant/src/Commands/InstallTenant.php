<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-13
 * Time: 16:41
 */

namespace Plugins\Tenant\Commands;

use Core\User\Repositories\Interfaces\UserInterface;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Support\Facades\Artisan;
use Plugins\Tenant\Repositories\Interfaces\TenantRepositories;
use Plugins\Tenant\Services\DatabaseConnection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use File;
use Symfony\Component\Process\Process;

class InstallTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:install {tenant_id : id of tenant} {connection? : connection of database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installation of tenant: Laravel setup, installation of npm packages';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var TenantRepositories
     */
    protected $tenantRepositories;

    /**
     * @var DatabaseConnection
     */
    protected $databaseConnection;

    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $database;

    /**
     * @var string
     */
    protected $password;

    /**
     * InstallTenant constructor.
     * @param UserInterface $user
     * @param DatabaseConnection $databaseConnection
     * @param Filesystem $files
     * @param TenantRepositories $tenantRepositories
     */
    public function __construct(UserInterface $user, DatabaseConnection $databaseConnection,
                                Filesystem $files, TenantRepositories $tenantRepositories)
    {
        parent::__construct();

        $this->userRepository = $user;
        $this->files = $files;
        $this->tenantRepositories = $tenantRepositories;
        $this->databaseConnection = $databaseConnection;
    }

    /**
     *
     */
    public function handle()
    {
        $extensions = get_loaded_extensions();
        $require_extensions = ['mbstring', 'openssl', 'curl', 'exif', 'fileinfo', 'tokenizer'];
        foreach (array_diff($require_extensions, $extensions) as $missing_extension) {
            $this->error('Missing ' . ucfirst($missing_extension) . ' extension');
        }

        $tenantId = $this->argument('tenant_id');
        $connectionName = $this->argument('connection');

        $this->setDatabaseInfo($tenantId, $connectionName);
    }

    /**
     * @param int $tenantId
     * @param string|null $connectionName
     * @throws \Exception
     */
    protected function setDatabaseInfo(int $tenantId, string $connectionName = null)
    {
        $tenant = $this->tenantRepositories->findById($tenantId);

        $connectionName = $connectionName ?? $this->databaseConnection->tenantName();

        $configDatabase = update_configuration_connection_tenant($tenant, $connectionName);
        $this->databaseConnection->connectToDBByConnectionName($connectionName);

        $this->database = $configDatabase['database'];
        $this->username = $configDatabase['username'];
        $this->password = $configDatabase['password'];

        if (!checkDatabaseConnection($connectionName)) {
            throw new \Exception('Can not connect to database, please try again!');
        }

        if (!empty($this->database)) {
            (new Process(sprintf('php artisan tenant:migrate %s %s %s', $tenantId, $connectionName, $connectionName), base_path()))
                ->mustRun()
                ->isSuccessful();

            // Active all plugin of tenant:
            $plugins = config('tenant.active-plugins');

            foreach ($plugins as $plugin) {
                (new Process(sprintf('php artisan tenant-plugin:activate %s %s', $plugin, $tenantId), base_path()))
                    ->mustRun()
                    ->isSuccessful();
            }
        }
        $this->call('db:seed', [
            '--database' => $connectionName,
        ]);

        $this->databaseConnection->updateCurrentDatabaseConnection();
        $this->databaseConnection->connectToDBByConnectionName();
    }
}
