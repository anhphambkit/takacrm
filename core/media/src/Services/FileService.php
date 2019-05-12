<?php

namespace Core\Media\Services;

use Illuminate\Contracts\Filesystem\Factory;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Core\Media\Repositories\Interfaces\MediaFileRepositories;
use Core\Media\Repositories\Interfaces\MediaFolderRepositories;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Core\Media\ValueObjects\MediaPath;
use Core\Media\Helpers\FileHelper;
use Core\Media\Models\MediaFile as File;
use Ramsey\Uuid\Uuid;

class FileService
{
    use DispatchesJobs;

    /**
     * @var Factory
     */
    protected $filesystem;

    /**
     * @var MediaFileRepositories
     */
    protected $fileRepository;

    /**
     * @var MediaFolderRepositories
     */
    protected $folderRepository;

    public function __construct(
    	MediaFolderRepositories $folderRepository, 
    	MediaFileRepositories $fileRepository, 
    	Factory $filesystem
    ) {
		$this->fileRepository   = $fileRepository;
		$this->filesystem       = $filesystem;
		$this->folderRepository = $folderRepository;
    }

    /**
     * @param  UploadedFile $file
     * @author TrinhLe
     * @return mixed
     */
    public function store(UploadedFile $fileUpload, $folderId = 0)
    {
        $savedFile = $this->createFromFile($fileUpload, $folderId);
        $path      = $this->getDestinationPath($savedFile->getOriginal('url'));
        $stream    = fopen($fileUpload->getRealPath(), 'r+');
        
        $this->filesystem->disk($this->getConfiguredFilesystem())->writeStream($path, $stream, [
            'visibility' => 'public',
            'mimetype' => $savedFile->mime_type,
        ]);

        $this->createThumbnails($savedFile->url);
        return $savedFile;
    }

    /**
     * Create a file row from the given file
     * Create uid for file upload
     * @param  UploadedFile $file
     * @return mixed
     */
    public function createFromFile(UploadedFile $fileUpload, $folderId)
    {
		$userId        = auth()->id();
		$folderPath    = str_finish($this->folderRepository->getFullPath($folderId, $userId), '/');
		$fileName      = FileHelper::slug($fileUpload->getClientOriginalName());
		$extension     = substr(strrchr($fileName, '.'), 1);
		$uuid4FileName = Uuid::uuid4();

		return $this->fileRepository->createOrUpdate([
			'name'          => "{$uuid4FileName}.{$extension}",
			'url'           => config('core-media.media.upload.files-path') . "{$folderPath}{$uuid4FileName}.{$extension}",
			'size'          => $fileUpload->getFileInfo()->getSize(),
			'mime_type'     => $fileUpload->getClientMimeType(),
			'folder_id'     => $folderId,
			'user_id'       => $userId,
			'options'       => request()->get('options', []),
			'is_public'     => request()->input('view_in') == 'public' ? 1 : 0,
			'storage'       => config('core-media.media.filesystem'),
			'real_filename' => pathinfo($fileName, PATHINFO_FILENAME),
		]);
    }

    /**
     * Create the necessary thumbnails for the given file
     * @param $savedFile
     */
    private function createThumbnails($savedFile)
    {
        return app('imagy')->createAll($savedFile);
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

    /**
     * @return string
     */
    private function getConfiguredFilesystem()
    {
        return config('core-media.media.filesystem');
    }
}
