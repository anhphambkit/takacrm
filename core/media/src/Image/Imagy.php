<?php

namespace Core\Media\Image;

use GuzzleHttp\Psr7\Stream;
use Illuminate\Contracts\Filesystem\Factory;
use Intervention\Image\ImageManager;
use Core\Media\Models\MediaFile as File;
use Core\Media\ValueObjects\MediaPath;

class Imagy
{
    /**
     * @var \Intervention\Image\Image
     */
    private $image;
    /**
     * @var ImageFactoryInterface
     */
    private $imageFactory;
    /**
     * @var ThumbnailManager
     */
    private $manager;

    /**
     * All the different images types where thumbnails should be created
     * @var array
     */
    private $imageExtensions = ['jpg', 'png', 'jpeg', 'gif'];
    /**
     * @var Factory
     */
    private $filesystem;

    /**
     * @param ImageFactoryInterface $imageFactory
     * @param ThumbnailManager $manager
     */
    public function __construct(ImageFactoryInterface $imageFactory, ThumbnailManager $manager)
    {
        $this->image        = app(ImageManager::class);
        $this->filesystem   = app(Factory::class);
        $this->imageFactory = $imageFactory;
        $this->manager      = $manager;
    }

    /**
     * Get an image in the given thumbnail options
     * @param  string $path
     * @param  string $thumbnail
     * @param  bool   $forceCreate
     * @return string
     */
    public function get($path, $thumbnail, $forceCreate = false)
    {
        if (!$this->isImage($path)) {
            return;
        }

        $filename = config('core-media.media.config.files-path') . $this->newFilename($path, $thumbnail);

        if ($this->returnCreatedFile($filename, $forceCreate)) {
            return $filename;
        }
        if ($this->fileExists($filename) === true) {
            $this->filesystem->disk($this->getConfiguredFilesystem())->delete($filename);
        }

        $mediaPath = (new MediaPath($filename))->getUrl();
        $this->makeNew($path, $mediaPath, $thumbnail);

        return (new MediaPath($filename))->getUrl();
    }

    /**
     * Return the thumbnail path
     * @param  string|File $originalImage
     * @param  string $thumbnail
     * @return string
     */
    public function getThumbnail($originalImage, $thumbnail)
    {
        $url = $originalImage->url;
        $path = config('core-media.media.config.files-path') . $this->newFilename($url, $thumbnail);
        return (new MediaPath($path, $originalImage->storage))->getUrl();
    }

    /**
     * Create all thumbnails for the given image path
     * @param MediaPath $path
     */
    public function createAll($path)
    {
        if (!$this->isImage($path)) {
            return;
        }

        foreach ($this->manager->all() as $thumbnail) {
            $clonenode = $this->filesystem
                            ->disk($this->getConfiguredFilesystem())
                            ->get($this->getDestinationPath($path));
            $image = $this->image->make($clonenode);
            $filename = config('core-media.media.config.files-path') . $this->newFilename($path, $thumbnail->name());
            foreach ($thumbnail->filters() as $manipulation => $options) {
                $image = $this->imageFactory->make($manipulation)->handle($image, $options);
            }
            $image = $image->stream(pathinfo($path, PATHINFO_EXTENSION), array_get($thumbnail->filters(), 'quality', 90));
            $this->writeImage($filename, $image);
        }
    }

    /**
     * Prepend the thumbnail name to filename
     * @param $path
     * @param $thumbnail
     * @return mixed|string
     */
    private function newFilename($path, $thumbnail)
    {
        $filename = pathinfo($path, PATHINFO_FILENAME);
        $dirname = pathinfo($path, PATHINFO_DIRNAME);
        return "{$dirname}/{$filename}" . '_' . $thumbnail . '.' . pathinfo($path, PATHINFO_EXTENSION);
    }

    /**
     * Return the already created file if it exists and force create is false
     * @param  string $filename
     * @param  bool   $forceCreate
     * @return bool
     */
    private function returnCreatedFile($filename, $forceCreate)
    {
        return $this->fileExists($filename) && $forceCreate === false;
    }

    /**
     * Write the given image
     * @param string $filename
     * @param Stream $image
     */
    private function writeImage($filename, Stream $image)
    {
        $filename = $this->getDestinationPath($filename);
        $resource = $image->detach();
        $config = [
            'visibility' => 'public',
            'mimetype' => \GuzzleHttp\Psr7\mimetype_from_filename($filename),
        ];
        if ($this->fileExists($filename)) {
            return $this->filesystem->disk($this->getConfiguredFilesystem())->updateStream($filename, $resource, $config);
        }
        $this->filesystem->disk($this->getConfiguredFilesystem())->writeStream($filename, $resource, $config);
    }

    /**
     * Make a new image
     * @param MediaPath      $path
     * @param string      $filename
     * @param string null $thumbnail
     */
    private function makeNew(MediaPath $path, $filename, $thumbnail)
    {
        $image = $this->image->make($path->getUrl());

        foreach ($this->manager->find($thumbnail) as $manipulation => $options) {
            $image = $this->imageFactory->make($manipulation)->handle($image, $options);
        }
        $image = $image->stream(pathinfo($path, PATHINFO_EXTENSION));

        $this->writeImage($filename, $image);
    }

    /**
     * Check if the given path is en image
     * @param  string $path
     * @return bool
     */
    public function isImage($path)
    {
        return in_array(pathinfo($path, PATHINFO_EXTENSION), $this->imageExtensions);
    }

    /**
     * Delete all files on disk for the given file in storage
     * This means the original and the thumbnails
     * @param $file
     * @return bool
     */
    public function deleteAllFor(File $file)
    {
        if (!$this->isImage($file->path)) {
            return $this->filesystem->disk($this->getConfiguredFilesystem())->delete($this->getDestinationPath($file->path->getRelativeUrl()));
        }

        $paths[] = $this->getDestinationPath($file->path->getRelativeUrl());
        $fileName = pathinfo($file->path, PATHINFO_FILENAME);
        $extension = pathinfo($file->path, PATHINFO_EXTENSION);
        foreach ($this->manager->all() as $thumbnail) {
            $path = config('core-media.media.config.files-path') . "{$fileName}_{$thumbnail->name()}.{$extension}";
            if ($this->fileExists($this->getDestinationPath($path))) {
                $paths[] = (new MediaPath($this->getDestinationPath($path)))->getRelativeUrl();
            }
        }

        return $this->filesystem->disk($this->getConfiguredFilesystem())->delete($paths);
    }

    /**
     * Description
     * @return type
     */
    private function getConfiguredFilesystem()
    {
        return config('core-media.media.filesystem');
    }

    /**
     * @param $filename
     * @return bool
     */
    private function fileExists($filename)
    {
        return $this->filesystem->disk($this->getConfiguredFilesystem())->exists($filename);
    }

    /**
     * @param string $path
     * @return string
     */
    private function getDestinationPath($path)
    {
        if ($this->getConfiguredFilesystem() === 'local') {
            return basename(public_path()) . $path;
        }

        return $path;
    }
}
