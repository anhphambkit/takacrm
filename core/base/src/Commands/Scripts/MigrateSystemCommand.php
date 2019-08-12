<?php
namespace Core\Base\Commands\Scripts;
use Illuminate\Console\Command;

class MigrateSystemCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lcms:migrate {path? : path of migration database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[lcms] Migrate data.';

    /**
     * Create a new key generator command.
     *
     * @param Composer $composer
     * @author TrinhLe
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * $dir => database_path('migrations')
     * @return mixed
     */
    public function handle() 
    {
        $path = $this->argument('path');
        $databaseConnection = config('core-base.cms.current_database_connection');

        if (!empty($path)) {
            $migrationPath = "database/migrations/{$path}";

            $this->call('vendor:publish', [
                '--tag' => "cms-migrations-{$path}", '--force' => true
            ]);

            $this->call('migrate', [
                '--path' => $migrationPath,
                '--database' => $databaseConnection,
                '--force' => true,
            ]);
        }

        $this->call('vendor:publish', [
            '--tag' => 'cms-migrations',
            '--force' => true
        ]);

        $this->call('migrate', [
            '--database' => $databaseConnection,
            '--force' => true,
        ]);
    }
}