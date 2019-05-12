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
    protected $signature = 'lcms:migrate';

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
     *
     * @return mixed
     */
    public function handle() 
    {
    	$this->call('vendor:publish', [
            '--tag' => 'cms-migrations', '--force' => true
        ]);
       	$this->call('migrate');
    }
}