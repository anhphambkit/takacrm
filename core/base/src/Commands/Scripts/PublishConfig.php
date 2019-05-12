<?php
namespace Core\Base\Commands\Scripts;
use Illuminate\Console\Command;

class PublishConfig extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'publish:config';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will publish config all packages.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() 
    {
        $this->call('vendor:publish', [
            '--tag' => 'config-packages', '--force' => true
        ]);
    }
}