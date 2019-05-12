<?php
namespace Core\Media\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Core\Media\Repositories\Interfaces\MediaShareRepositories;
use Illuminate\Http\Request;
use Core\Media\Models\User;
use BMedia;

class MediaShareController extends BaseAdminController
{
	/**
     * @var MediaShareRepositories
     */
    protected $shareRepository;

    /**
     * MediaShareController constructor.
     * @param MediaShareRepositories $mediaShareRepository
     * @author TrinhLe
     */
    public function __construct(MediaShareRepositories $mediaShareRepository)
    {
        $this->shareRepository = $mediaShareRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function getSharedUsers(Request $request)
    {
        $currentUserId = auth()->id();
        $shareId      = $request->input('share_id');
        $shareType    = $request->input('is_folder') == 'false' ? 'file' : 'folder';
        $sharedUsers  = $this->shareRepository->getSharedUsers($currentUserId, $shareId, $shareType)->pluck('id')->all();
        $users         = User::getListUsers($currentUserId);

        foreach ($users as $user) {
            $user->is_selected = 0;
            if (in_array($user->id, $sharedUsers)) {
                $user->is_selected = 1;
            }
        }

        return BMedia::responseSuccess(compact('users'));
    }    
}