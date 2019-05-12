<?php

namespace Core\Media\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Contracts\Filesystem\Factory;
use Core\Media\ValueObjects\MediaPath;
use Core\Media\Image\ThumbnailManager;
use Core\Media\Models\MediaFile as File;
use Illuminate\Support\Collection;
use Core\Media\Repositories\Interfaces\MediaFolderRepositories;
class BFileService
{
    /**
     * @var Factory
     */
    private $filesystem;

    /**
     * @var Factory
     */
    private $manager;

    /**
     * @var FileService
     */
    private $fileService;

    /**
     * @var Storages
     */
    private $storages = [ 's3', 'local' ];

    /**
     * All the different images types where thumbnails should be created
     * @var array
     */
    private $imageExtensions = ['jpg', 'png', 'jpeg', 'gif'];

    public function __construct(Factory $filesystem, ThumbnailManager $manager, FileService $fileService)
    {
        $this->filesystem  = $filesystem;
        $this->manager     = $manager;
        $this->fileService = $fileService;
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
    public function deleteAllFor($files, $pathAttr = "url")
    {
        $ids = array();
        foreach ($files as $file) {
            # code...
            $this->deleteMedia($file, $pathAttr);
            $ids[] = $file->id;
        }
        return File::whereIn('id', $ids)->delete();
    }

    /**
     * Delete media
     * @param type $path 
     * @param type $storage 
     * @param type $extension 
     * @return type
     */
    public function deleteMedia($file, $pathAttr = "url")
    {
        list($path, $storage) = $this->validation($file, $pathAttr);
        list($urlPath, $fullPath, $filePath, $paths, $extension, $baseDir) = $this->listArrDestroy($path, $storage);

        if (!$this->isImage($urlPath)) {
            return $this->filesystem->disk($storage)->delete($filePath);
        }

        foreach ($this->manager->all() as $thumbnail) {
            $thumbPath = $baseDir . "_{$thumbnail->name()}.{$extension}";
            if ($this->fileExists($storage, $thumbPath)) {
                $paths[] = (new MediaPath($thumbPath))->getRelativeUrl();
            }
        }
        
        return $this->filesystem->disk($storage)->delete($paths);
    }

    /**
     * Description
     * @param type $path 
     * @param type $storage 
     * @return type
     */
    private function listArrDestroy($path, $storage)
    {
        $urlPath   = $this->renderUrl($path, $storage);
        $fullPath  = "/{$path}";
        $filePath  = $this->getDestinationPath($fullPath, $storage);
        $paths[]   = $filePath;
        $extension = pathinfo($urlPath, PATHINFO_EXTENSION);
        $baseDir   = str_replace(".{$extension}", "", $filePath);

        return [ $urlPath, $fullPath, $filePath, $paths, $extension, $baseDir ];
    }

    /**
     * @param $filename
     * @return bool
     */
    private function fileExists($storage, $filename)
    {
        return $this->filesystem->disk($storage)->exists($filename);
    }

    /**
     * Convert file path to url
     * @author  TrinhLe
     * @param mixed $files
     * @param string $fileNameAttr
     * @param string $pathAttr
     * @param bool $isRealName
     * @return mixed
     */
    public function convertFiles($files, $isRealName = true, $fileNameAttr = "filename", $pathAttr = "path")
    {
        foreach ($files as &$file) {
            # code...
            $this->convertSingleFile($file, $isRealName, $fileNameAttr, $pathAttr);
        }
        return $files;
    }

    /**
     * @param $file
     * @param bool $isRealName
     * @param string $fileNameAttr
     * @param string $pathAttr
     * @return mixed
     */
    public function convertSingleFile(&$file, $isRealName = true, $fileNameAttr = "filename", $pathAttr = "path") 
    {
        if ($file->{$pathAttr}) {
            $file->{$pathAttr} = $this->getMediaUrl($file, $pathAttr);
            if($isRealName === true && $file->real_filename)
                $file->{$fileNameAttr} = $file->real_filename;
        }
        return $file;
    }

    /**
     * Get url media of a eloquent
     * @author TrinhLe
     * @return mixed
     */
    public function getMediaUrl($file, $pathAttr = "url")
    {
        list($path, $storage) = $this->validation($file, $pathAttr);
        return $this->renderUrl($path, $storage);
    }

    /**
     * Validation file media
     * @author  TrinhLE
     * @param type $file 
     * @return type
     */
    protected function validation($file, $pathAttr = "url")
    {
        $storage = $file->storage;
        if(!in_array($storage, $this->storages)) throw new \Exception("Invalid storage type is {$storage}", 1);
        return [ $file->url, $storage ];
    }

    /**
     * @param string $path
     * @return string
     */
    private function getDestinationPath($path, $storage)
    {
        if ($storage === 'local') {
            return basename(public_path()) . $path;
        }

        return $path;
    }

    /**
     * Description
     * @param type $file 
     * @return type
     */
    public function isExists($file, $pathAttr = "url")
    {
        list($path, $storage) = $this->validation($file, $pathAttr);
        $path = "/{$path}";
        $path = $this->getDestinationPath($path, $storage);
        if($this->filesystem->disk($storage)->exists($path)) return $path;
    }

    /**
     * Render url from storage media
     * @param string $path 
     * @param string $storage 
     * @return string
     */
    public function renderUrl(string $path, string $storage)
    {
        return (new MediaPath($path, $storage))->getUrl();
    }

    /**
     * Get content media from file storage
     * @author  TrinhLe
     * @param string $path
     * @param string $storage
     * @return mixed
     */
    public function getFileDocument(string $path, string $storage = 's3')
    {
        if(!in_array($storage, $this->storages)) return;

        $path = $this->getDestinationPath($path, $storage);

        if($this->filesystem->disk($storage)->exists($path)){
            return $this->filesystem->disk($storage)->get($path);
        }

        // EmailException::sendErrorException(new \Exception(__("File does not exists with path: {$path}")));
    }

    /**
     * Description
     * @param type $filePath 
     * @return type
     */
    public function unlinkLocalFile($filePath)
    {
        $localPath = public_path($filePath);
        if(file_exists($localPath))
            unlink($localPath);
    }

    /**
     * Description
     * @param type $filePath 
     * @param type $storage 
     * @return type
     */
    public function downloadFile($file, $pathAttr = "url")
    {
        if($file->storage === 'local') return response()->download(storage_path("app/public{$file->url}"));
                    
        $filePath = $this->renderUrl($file->{$pathAttr}, $file->storage);
        return response()->streamDownload(function () use($filePath){
            echo file_get_contents($filePath);
        }, pathinfo($filePath, PATHINFO_BASENAME));
    }

    /**
     * Clean folder
     * @param type $folder 
     */
    public function cleanFolder($folder)
    {
        $path = config('core-media.media.upload.files-path') . app(MediaFolderRepositories::class)->getFullPath($folder->id, auth()->id());
        $this->filesystem->disk('s3')->deleteDirectory($path);
        $this->filesystem->disk('local')->deleteDirectory("/public{$path}");
    }
}
