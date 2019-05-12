<?php

namespace Core\Media\ValueObjects;

use Illuminate\Support\Facades\Storage;

class MediaPath
{
    /**
     * @var string
     */
    private $path;

     /**
     * @var string
     */
    private $storage;

    public function __construct($path, $storage = 'local')
    {
        if (! is_string($path)) {
            throw new \InvalidArgumentException('The path must be a string');
        }

        $this->path    = $path;
        $this->storage = $storage;
    }

    /**
     * Get the URL depending on configured disk
     * @return string
     */
    public function getUrl()
    {
        $path = ltrim($this->path, '/');
        return Storage::disk($this->storage)->url($path);
    }

    /**
     * @return string
     */
    public function getRelativeUrl()
    {
        return $this->path;
    }

    /**
     * Description
     * @return type
     */
    public function __toString()
    {
        try {
            return $this->getUrl();
        } catch (\Exception $e) {
            return '';
        }
    }
}
