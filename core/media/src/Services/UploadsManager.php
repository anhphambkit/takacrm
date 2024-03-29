<?php

namespace Core\Media\Services;

use Core\Media\Models\MediaFile;
use Carbon\Carbon;
use Storage;
use File;

class UploadsManager
{
    /**
     * @var mixed
     */
    protected $disk;


    /**
     * Sanitize the folder name
     *
     * @param $folder
     * @return string
     * @author Trinh Le
     */
    protected function cleanFolder($folder)
    {
        return DIRECTORY_SEPARATOR . trim(str_replace('..', '', $folder), DIRECTORY_SEPARATOR);
    }

    /**
     * Return an array of file details for a file
     *
     * @param $path
     * @return array
     * @author Trinh Le
     */
    public function fileDetails($path)
    {
        return [
            'filename'  => basename($path),
            'url'       => '/' . $this->uploadPath($path),
            'mime_type' => $this->fileMimeType($path),
            'size'      => $this->fileSize($path),
            'modified'  => $this->fileModified($path),
        ];
    }

    /**
     * Return the full web path to a file
     *
     * @param $path
     * @return string
     * @author Trinh Le
     */
    public function uploadPath($path)
    {
        return rtrim(ltrim(str_replace('\\', '', str_replace(public_path(), '', config('media.upload.path'))), '/'), '/') . '/' . ltrim($path, '/');
    }

    /**
     * Return the mime type
     *
     * @param $path
     * @return mixed|null|string
     * @author Trinh Le
     */
    public function fileMimeType($path)
    {
        return array_get(MediaFile::$mimeTypes, strtolower(File::extension($path)));
    }

    /**
     * Return the file size
     *
     * @param $path
     * @return int
     * @author Trinh Le
     */
    public function fileSize($path)
    {
        return $this->disk->size($path);
    }

    /**
     * Return the last modified time
     *
     * @param $path
     * @return string
     * @author Trinh Le
     */
    public function fileModified($path)
    {
        return Carbon::createFromTimestamp(
            $this->disk->lastModified($path)
        );
    }

    /**
     * Create a new directory
     *
     * @param $folder
     * @return bool|string|\Symfony\Component\Translation\TranslatorInterface
     * @author Trinh Le
     */
    public function createDirectory($folder)
    {
        $folder = $this->cleanFolder($folder);

        if ($this->disk->exists($folder)) {
            return trans('media::media.folder_exists', ['folder' => $folder]);
        }

        return $this->disk->makeDirectory($folder);
    }

    /**
     * Delete a directory
     *
     * @param $folder
     * @return bool|string|\Symfony\Component\Translation\TranslatorInterface
     * @author Trinh Le
     */
    public function deleteDirectory($folder)
    {
        $folder = $this->cleanFolder($folder);

        $filesFolders = array_merge(
            $this->disk->directories($folder),
            $this->disk->files($folder)
        );
        if (!empty($filesFolders)) {
            return trans('core-media::media.directory_must_empty');
        }

        return $this->disk->deleteDirectory($folder);
    }

    /**
     * Delete a file
     *
     * @param $path
     * @return bool|string|\Symfony\Component\Translation\TranslatorInterface
     * @author Trinh Le
     */
    public function deleteFile($path)
    {
        $path = $this->cleanFolder($path);

        if (!$this->disk->exists($path)) {
            info(trans('media::media.file_not_exists'));
        }

        if (is_image($this->fileMimeType($path))) {
            $filename = pathinfo($path, PATHINFO_FILENAME);
            $thumb    = str_replace($filename, $filename . '-' . config('media.sizes.thumb'), $path);
            $featured = str_replace($filename, $filename . '-' . config('media.sizes.featured'), $path);

            return $this->disk->delete([$path, $thumb, $featured]);
        } else {
            return $this->disk->delete([$path]);
        }
    }

    /**
     * Save a file
     *
     * @param $path
     * @param $content
     * @return bool|string|\Symfony\Component\Translation\TranslatorInterface
     * @author Trinh Le
     */
    public function saveFile($path, $content)
    {
        $path = $this->cleanFolder($path);

        return $this->disk->put($path, $content);
    }
}
