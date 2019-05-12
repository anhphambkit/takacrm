<?php
namespace Core\Media\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\Media\Repositories\Interfaces\MediaFileRepositories;
use Core\Media\Repositories\Interfaces\MediaFolderRepositories;
use Core\Media\Requests\MediaFileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use BMedia;

class MediaFileController extends BaseAdminController
{
    /**
     * @var MediaFileRepositories
     */
    protected $fileRepository;

    /**
     * @var MediaFolderRepositories
     */
    protected $folderRepository;

    /**
     * @param MediaFileRepositories $fileRepository
     * @param MediaFolderRepositories $folderRepository
     * @author TrinhLe
     */
    public function __construct(
        MediaFileRepositories $fileRepository,
        MediaFolderRepositories $folderRepository
    )
    {
		$this->fileRepository   = $fileRepository;
		$this->folderRepository = $folderRepository;
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @author TrinhLe
     */
    public function postAddExternalService(Request $request)
    {
        $type = $request->input('type');
        if (!in_array($type, config('media.external_services'))) {
            return BMedia::responseError(trans('media::media.invalid_request'));
        }

        $file = $this->fileRepository->getModel();
        $file->name = $this->fileRepository->createName($request->input('name'), $request->input('folder_id'));
        $file->url = $request->input('url');
        $file->size = 0;
        $file->mime_type = $type;
        $file->folder_id = $request->input('folder_id');
        $file->user_id = auth()->id();
        $file->options = $request->input('options', []);
        $file->is_public = $request->input('view_in') == 'public' ? 1 : 0;
        $this->fileRepository->createOrUpdate($file);

        return BMedia::responseSuccess(trans('media::media.add_success'));
    }

    /**
     * @param MediaFileRequest $request
     * @return JsonResponse
     * @author TrinhLe
     */
    public function postUpload(MediaFileRequest $request)
    {
        $result = BMedia::handleUpload(array_first($request->file('file')), $request->input('folder_id', 0));

        if ($result['error'] == false) {
            return BMedia::responseSuccess([
                'id' => $result['data']->id,
            ]);
        }

        return BMedia::responseError($result['message']);
    }

    /**
     * @param MediaFileRequest $request
     * @return JsonResponse
     * @author TrinhLe
     */
    public function postUploadFromEditor(MediaFileRequest $request)
    {
        $result = BMedia::handleUpload($request->file('upload'), 0);

        if ($result['error'] == false) {
            $file = $result['data'];
            if ($request->input('upload_type') == 'tinymce') {
                return response('<script>parent.setImageValue("' . url($file->url) . '"); </script>')->header('Content-Type', 'text/html');
            }

            return response('<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("' . $request->input('CKEditorFuncNum') . '", "' . (config('filesystems.default') === 'local' ? '/' . ltrim($file->url, '/') : $file->url) . '", "");</script>')->header('Content-Type', 'text/html');
        }

        return response('<script>alert("' . Arr::get($result, 'message') . '")</script>')->header('Content-Type', 'text/html');
    }
   
}