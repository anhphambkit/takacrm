<?php
namespace Core\Base\Commands\Scripts;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Core\Master\Supports\PublishStub;
class MakeRepositoryCommand extends Command
{
    use PublishStub;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repo {name : The module that you want to create} {repo} {--P|plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '[Eden] Make new repo.';

    /**
     * Create a new key generator command.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     * @param Composer $composer
     * @author TrinhLe
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() 
    {
        $coreNamespace = $this->option('plugin') ? 'Plugins' : 'Core';
        $basePath      = $this->option('plugin') ? config('core-base.cms.plugin_path') : config('core-base.cms.core_path');
        $repo = $this->argument('repo');

        $this->plugin = ucfirst(strtolower($this->argument('name')));
        $baseDirectory = $basePath . '/' . strtolower($this->plugin);
        $this->location = $basePath . '/' . strtolower($this->plugin) . '/src/Repositories';

        $fromStub = base_path('core/base/stubs/repository/Repositories');

        $this->dataTranslate = [
            "{CoreNamespace}" => $coreNamespace,
            "{Repo}" => studly_case($repo),
            "{Package}" => studly_case($this->plugin),
        ];

        $this->filenameTranslate = [
            "{Repo}" => studly_case($repo),
            ".stub" => ".php",
        ];
        
        $this->publishStubs($fromStub);
        $this->renameFileName($this->location);
        $this->searchAndReplaceInFiles();

        $this->line('------------------');
        $this->line('<info>The plugin repository</info> <comment>' . studly_case($this->plugin) . '</comment> <info>was created in</info> <comment>' . $this->location . '</comment><info>, customize it!</info>');
        $this->line('------------------');

        if ($this->confirm('Do you want to bind repo with interface?')) 
        {
            $params = ['package' => studly_case($this->plugin), 'repo' => studly_case($repo)];
            if($this->option('plugin'))
                $params = array_merge(['--plugin' => '--plugin'], $params);
            return $this->call("make:bind-repo",$params);
        }
    }
}