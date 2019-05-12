<?php

namespace Core\Base\Commands\Scripts;

use Artisan;
use Core\Base\Models\Migration;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Schema;
use Core\Base\Repositories\Interfaces\PluginRepositories;

class PluginRemoveCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'plugin:remove {name : The module that you want to remove}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove a plugin in the /plugins directory.';

    /**
     * @var Composer
     */
    protected $composer;

    /**
     * Create a new key generator command.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param Composer $composer
     * @author TrinhLe
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     * @author TrinhLe
     */
    public function handle()
    {
        if (!preg_match('/^[a-z\-]+$/i', $this->argument('name'))) {
            $this->error('Only alphabetic characters are allowed.');
            return false;
        }

        $plugin = ucfirst(strtolower($this->argument('name')));
        $location = config('core-base.cms.plugin_path') . '/' . strtolower($plugin);

        if ($this->files->isDirectory($location)) {

            if ($this->confirm('Are you sure you want to permanently delete? [yes|no]')) {

                $this->call('plugin:deactivate', ['name' => strtolower($plugin)]);

                $content = get_file_data($location . '/plugin.json');
                if (!empty($content)) {
                    Schema::disableForeignKeyConstraints();
                    call_user_func([$content['plugin'], 'remove']);
                    Schema::enableForeignKeyConstraints();
                    app(PluginRepositories::class)->deleteBy(['provider' => $content['provider']]);
                    $this->line('<info>Remove plugin successfully!</info>');
                }

                $migrations = scan_folder($location . '/database/migrations');
                foreach ($migrations as $migration) {
                    Migration::where('migration', pathinfo($migration, PATHINFO_FILENAME))->delete();
                }

                $this->files->deleteDirectory($location);

                if (empty($this->files->directories(config('core-base.cms.plugin_path')))) {
                    $this->files->deleteDirectory(config('core-base.cms.plugin_path'));
                }

                $composer = get_file_data(base_path() . '/composer.json');
                if (!empty($composer)) {
                    unset($composer['autoload']['psr-4']['Plugins\\' . studly_case($plugin) . '\\']);
                    save_file_data(base_path() . '/composer.json', $composer);
                }

                $this->composer->dumpAutoloads();
                $this->line('Composer autoload refreshed!');
                Artisan::call('cache:clear');
            }
        } else {
            $this->line('This plugin is not exists!');
        }

        return true;
    }
}
