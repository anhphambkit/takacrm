<?php

namespace Core\Base\Commands\Scripts;

use Core\User\Repositories\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Question\Question;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Exception;
use Artisan;
use File;
use DB;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lcms:install {type? : type install}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installation of LCMS: Laravel setup, installation of npm packages';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

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
     * Install constructor.
     * @param UserInterface $user
     * @param Filesystem $files
     * @author TrinhLe
     */
    public function __construct(UserInterface $user, Filesystem $files)
    {
        parent::__construct();

        $this->userRepository = $user;
        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @author TrinhLe
     */
    public function handle()
    {
        $this->line('------------------');
        $this->line('Welcome to LCMS');
        $this->line('------------------');

        $extensions = get_loaded_extensions();
        $require_extensions = ['mbstring', 'openssl', 'curl', 'exif', 'fileinfo', 'tokenizer'];
        foreach (array_diff($require_extensions, $extensions) as $missing_extension) {
            $this->error('Missing ' . ucfirst($missing_extension) . ' extension');
        }

        if (!file_exists('.env')) {
            File::copy('.env-example', '.env');
            Artisan::call('key:generate');
        }

        // Set database credentials in .env and migrate
        $type = $this->argument('type');
        $this->setDatabaseInfo($type);
        $this->line('------------------');

        // Set cache key prefix
        $this->setCacheKeyPrefix($this->database);
        $this->line('------------------');

        // Create a super user
        if (empty($type))
            $this->call("create:user");
        
        $this->completed();

        Artisan::call('cache:clear');
        $this->line('------------------');
        $this->line('Done. Enjoy LCMS!');
    }

    /**
     * @param $prefix
     * @return void
     * @author TrinhLe
     */
    protected function setCacheKeyPrefix($prefix)
    {
        $path = 'config/cache.php';
        list($path, $contents) = [$path, $this->files->get($path)];

        $contents = str_replace($this->laravel['config']['cache.prefix'], $prefix, $contents);

        $this->files->put($path, $contents);

        $this->laravel['config']['cache.prefix'] = $prefix;

        $this->info('Application cache key prefix ' . $prefix . ' set successfully.');
    }

    /**
     * @param string $type
     * @throws Exception
     */
    protected function setDatabaseInfo(string $type = null)
    {
        $this->info('Setting up database (please make sure you created database for this site)...');

        $this->database = env('DB_DATABASE');
        $this->username = env('DB_USERNAME');
        $this->password = env('DB_PASSWORD');

        while (!checkDatabaseConnection()) {
            // Ask for database name
            $this->database = $this->ask('Enter a database name', $this->guessDatabaseName());

            $this->username = $this->ask('What is your MySQL username?', 'root');

            $question = new Question('What is your MySQL password?', '<none>');
            $question->setHidden(true)->setHiddenFallback(true);
            $this->password = (new SymfonyQuestionHelper())->ask($this->input, $this->output, $question);
            if ($this->password === '<none>') {
                $this->password = '';
            }

            // Update DB credentials in .env file.
            $contents = $this->getKeyFile();
            $contents = preg_replace('/(' . preg_quote('DB_DATABASE=') . ')(.*)/', 'DB_DATABASE=' . $this->database, $contents);
            $contents = preg_replace('/(' . preg_quote('DB_USERNAME=') . ')(.*)/', 'DB_USERNAME=' . $this->username, $contents);
            $contents = preg_replace('/(' . preg_quote('DB_PASSWORD=') . ')(.*)/', 'DB_PASSWORD=' . $this->password, $contents);

            if (!$contents) {
                throw new Exception('Error while writing credentials to .env file.');
            }

            // Write to .env
            $this->files->put('.env', $contents);

            // Set DB username and password in config
            $this->laravel['config']['database.connections.mysql.username'] = $this->username;
            $this->laravel['config']['database.connections.mysql.password'] = $this->password;

            // Clear DB name in config
            unset($this->laravel['config']['database.connections.mysql.database']);

            if (!checkDatabaseConnection()) {
                $this->error('Can not connect to database, please try again!');
            } else {
                $this->info('Connect to database successfully!');
            }
        }

        if (!empty($this->database)) {
            $this->call('lcms:migrate', [
                'path' => $type
            ]);
        }
    }

    /**
     * Guess database name from app folder.
     *
     * @return string
     * @author TrinhLe
     */
    protected function guessDatabaseName()
    {
        try {
            $segments = array_reverse(explode(DIRECTORY_SEPARATOR, app_path()));
            $name = explode('.', $segments[1])[0];

            return str_slug($name);
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * Get the key file and return its content.
     *
     * @return string
     * @author TrinhLe
     */
    protected function getKeyFile()
    {
        return $this->files->exists('.env') ? $this->files->get('.env') : $this->files->get('.env.example');
    }

    /**
     * Complete install cms
     * @author TrinhLe
     */
    protected function completed(){
        $env = $this->files->get('.env');
        $env = str_replace('INSTALLED=false', 'INSTALLED=true', $env);
        $this->files->put('.env', $env);
    }
}
