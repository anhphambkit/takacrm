<?php

namespace Core\Media\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Core\Media\ValueObjects\MediaPath;

class CreateThumbnails implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * @var MediaPath
     */
    private $path;

    public function __construct(MediaPath $path)
    {
        $this->path = $path;
    }

    /**
     * Creage thumbnail image
     * @author  unknown
     * @return mixed
     */
    public function handle()
    {
        $imagy = app('imagy');
        return $imagy->createAll($this->path);
    }
}
