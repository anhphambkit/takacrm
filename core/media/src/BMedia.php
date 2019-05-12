<?php

namespace Core\Media;

use Core\Media\Services\FileService;
use Exception;

class BMedia
{
    /**
     * @var array
     */
    protected $permissions = [];

    /**
     * @var FileService
     */
    protected $fileService;

    /**
     * @param FileService $fileService
     * @author TrinhLe
     */
    public function __construct(
        FileService $fileService
    ) {
        $this->fileService      = $fileService;
        $this->permissions = config('core-media.media.permissions', []);
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function renderHeader()
    {
        $urls = $this->getUrls();
        return view('core-media::header', compact('urls'))->render();
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function renderFooter()
    {
        return view('core-media::footer')->render();
    }

    /**
     * @return string
     * @author TrinhLe
     */
    public function renderContent()
    {
        return view('core-media::content')->render();
    }

    /**
     * Get all urls
     *
     * @return array
     * @author TrinhLe
     */
    public function getUrls()
    {
        return [
            'base_url'                 => asset(''),
            'base'                     => url(config('core-media.media.route.prefix')),
            'get_media'                => route('media.list'),
            'create_folder'            => route('media.folders.create'),
            'get_quota'                => route('media.quota'),
            'popup'                    => route('media.popup'),
            'download'                 => route('media.download'),
            'upload_file'              => route('media.files.upload'),
            'add_external_service'     => route('media.files.add_external_service'),
            'get_breadcrumbs'          => route('media.breadcrumbs'),
            'global_actions'           => route('media.global_actions'),
            'get_users'                => route('media.users.list'),
            'get_shared_users'         => route('media.shares.list_shared_users'),
            'media_upload_from_editor' => route('media.files.upload.from.editor'),
        ];
    }

    /**
     * @param $data
     * @param null $message
     * @return \Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function responseSuccess($data, $message = null)
    {
        return response()->json([
            'error' => false,
            'data' => $data,
            'message' => $message,
        ]);
    }

    /**
     * @param $message
     * @param array $data
     * @param null $code
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function responseError($message, $data = [], $code = null, $status = 200)
    {
        return response()->json([
            'error' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ], $status);
    }

    /**
     * @param $url
     * @return array|mixed
     */
    public function getAllImageSizes($url)
    {
        $images = [];
        foreach (config('core-media.media.sizes') as $size) {
            $readable_size = explode('x', $size);
            $images = get_image_url($url, $readable_size);
        }

        return $images;
    }

    /**
     * Handle upload media file
     * @author  TrinhLe
     * @param type $fileUpload 
     * @param type $folder_id 
     * @return \Illuminate\Http\JsonResponse|array
     * @throws Exception
     */
    public function handleUpload($fileUpload, $folder_id = 0)
    {
        if ($fileUpload->getSize() / 1024 > (int)config('core-media.media.max_file_size_upload')) {
            return [
                'error' => true,
                'message' => trans('media::media.file_too_big', ['size' => config('core-media.media.max_file_size_upload')]),
            ];
        }
        return [
            'error' => false,
            'data' => $this->fileService->store($fileUpload, $folder_id)
        ];
            
    }

    /**
     * @param array $permissions
     * @author TrinhLe
     */
    public function setPermissions(array $permissions)
    {
        $this->permissions = $permissions;
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * @param $permission
     * @author TrinhLe
     */
    public function removePermission($permission)
    {
        array_forget($this->permissions, $permission);
    }

    /**
     * @param $permission
     * @author TrinhLe
     */
    public function addPermission($permission)
    {
        $this->permissions[] = $permission;
    }

    /**
     * @param $permission
     * @return bool
     * @author TrinhLe
     */
    public function hasPermission($permission)
    {
        return in_array($permission, $this->permissions);
    }

    /**
     * @param array $permissions
     * @return bool
     * @author TrinhLe
     */
    public function hasAnyPermission(array $permissions)
    {
        $has_permission = false;
        foreach ($permissions as $permission) {
            if (in_array($permission, $this->permissions)) {
                $has_permission = true;
                break;
            }
        }
        return $has_permission;
    }

    /**
     * Returns a file size limit in bytes based on the PHP upload_max_filesize and post_max_size
     * @return float|int
     * @author TrinhLe
     */
    public function getServerConfigMaxUploadFileSize()
    {
        // Start with post_max_size.
        $max_size = $this->parseSize(ini_get('post_max_size'));

        // If upload_max_size is less, then reduce. Except if upload_max_size is
        // zero, which indicates no limit.
        $upload_max = $this->parseSize(ini_get('upload_max_filesize'));
        if ($upload_max > 0 && $upload_max < $max_size) {
            $max_size = $upload_max;
        }

        return $max_size;
    }

    /**
     * @param $size
     * @return float - bytes
     * @author TrinhLe
     */
    public function parseSize($size)
    {
        $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
        $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
        if ($unit) {
            // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
            return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
        }
        return round($size);
    }
}
