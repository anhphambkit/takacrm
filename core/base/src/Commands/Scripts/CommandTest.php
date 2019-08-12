<?php

namespace Core\Base\Commands\Scripts;

use Illuminate\Console\Command;
use Illuminate\Filesystem\FilesystemManager;
use Illuminate\Support\Composer;
use Core\Media\Models\MediaFile;
use Core\Media\Models\MediaFolder;
use Illuminate\Contracts\Filesystem\Factory;
use Core\User\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\Process\Process;

class CommandTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Regenerate command';

    /**
     * The Composer instance.
     *
     * @var \Illuminate\Support\Composer
     */
    protected $composer;
    protected $filesystemManager;

    /**
     * Create a new command instance.
     *
     * @param Composer $composer
     */
    public function __construct(Composer $composer, FilesystemManager $filesystemManager)
    {
        parent::__construct();

        $this->composer = $composer;
        $this->filesystemManager = $filesystemManager;
    }

    /**
     * @return bool
     */
    public function handle()
    {

    }

    /**
     * @param string|null $diskType
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    public function serviceFilesystem(string $diskType = null)
    {
        return $this->filesystemManager->disk(!empty($diskType) ? $diskType : config('filesystems.default'));
    }
}