<?php

namespace Core\Base\Commands\Scripts;

use Artisan;
use Core\Base\Repositories\Interfaces\PluginRepositories;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Core\Master\Supports\LoadRegisterTrait;

class PluginDeactivateCommand extends Command
{
    use LoadRegisterTrait;

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
    protected $signature = 'plugin:deactivate {name : The plugin that you want to deactivate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate a plugin in /plugins directory';

    /**
     * Create a new key generator command.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @author TrinhLe
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * @throws Exception
     * @return boolean
     * @author TrinhLe
     */
    public function handle()
    {

        if (!preg_match('/^[a-z\-]+$/i', $this->argument('name'))) {
            $this->error('Only alphabetic characters are allowed.');
            return false;
        }

        $plugin_folder = ucfirst(strtolower($this->argument('name')));
        $location = config('core-base.cms.plugin_path') . '/' . strtolower($plugin_folder);

        $content = get_file_data($location . '/plugin.json');
        if (!empty($content)) {

            $namespace = str_replace('\\Plugin', '\\', $content['plugin']);
            $composer = get_file_data(base_path() . '/composer.json');

            if (!empty($composer) && !isset($composer['autoload']['psr-4'][$namespace])) {
                $composer['autoload']['psr-4'][$namespace] = 'plugins/' . strtolower($plugin_folder) . '/src';
                save_file_data(base_path() . '/composer.json', $composer);
                Artisan::call('dump-autoload');
            }

            $plugin = app(PluginRepositories::class)->getFirstBy(['provider' => $content['provider']]);
            if (empty($plugin) || $plugin->status == 1) {
                call_user_func([$content['plugin'], 'deactivate']);
                if (empty($plugin)) {
                    $plugin = app(PluginRepositories::class)->getModel();
                    $plugin->fill($content);
                }
                $plugin->alias = strtolower($plugin_folder);
                $plugin->status = 0;
                app(PluginRepositories::class)->createOrUpdate($plugin);
                $this->flushAllCacheProvider();
                $this->line('<info>Deactivate plugin successfully!</info>');
            } else {
                $this->line('<info>This plugin is deactivated already!</info>');
            }
        }
                
        $this->call('cache:clear');

        if (!$this->files->isDirectory($location)) {
            $this->error('This plugin is not exists.');
            return false;
        }
        return true;
    }
}
