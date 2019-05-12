<?php
namespace Core\Media\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\Media\Repositories\Interfaces\MediaFileRepositories;
use Core\Media\Repositories\Interfaces\MediaFolderRepositories;
use Core\Media\Requests\MediaFolderRequest;
use BMedia;
use Illuminate\Http\JsonResponse;
use Exception;

class MediaFolderController extends BaseAdminController
{
    /**
     * @var MediaFolderInterface
     */
    protected $folderRepository;

    /**
     * FolderController constructor.
     * @param MediaFolderInterface $folderRepository
     * @author TrinhLe
     */
    public function __construct(MediaFolderRepositories $folderRepository)
    {
        $this->folderRepository = $folderRepository;
        parent::__construct();
    }

    /**
     * @param MediaFolderRequest $request
     * @return JsonResponse
     * @author TrinhLe
     */
    public function postCreate(MediaFolderRequest $request)
    {
        $name = $request->input('name');

        if (in_array($name, config('core-media.media.upload.reserved_names', []))) {
            return BMedia::responseError(trans('core-media::media.name_reserved'));
        }

        try {
            $userId = auth()->id();
            $parent_id         = $request->input('parent_id');
            $folder            = $this->folderRepository->getModel();
            $folder->user_id   = auth()->id();
            $folder->name      = $this->folderRepository->createName($name, $parent_id, $userId);
            $folder->slug      = $this->folderRepository->createSlug($name, $parent_id, $userId);
            $folder->parent_id = $parent_id;
            $this->folderRepository->createOrUpdate($folder);
            return BMedia::responseSuccess([], trans('core-media::media.folder_created'));
        } catch (Exception $ex) {
            return BMedia::responseError($ex->getMessage());
        }
    }
   
}