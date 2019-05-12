<?php
/**
 * MediaShare repository implemented
 */
namespace Core\Media\Repositories\Eloquent;
use Core\Media\Repositories\Interfaces\MediaShareRepositories;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Request;

class EloquentMediaShareRepositories extends RepositoriesAbstract implements MediaShareRepositories {
	
	/**
     * @param int $folderId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     * @author TrinhLe
     */
    public function getSharedFiles($userId, $folderId = 0)
    {
        return $this->model->join('media_files', 'media_files.id', '=', 'media_shares.share_id')
            ->where([
                'media_shares.share_type' => 'file',
                'media_shares.shared_by' => $userId,
                'media_files.folder_id' => $folderId,
            ])
            ->select(['media_shares.share_id', 'media_files.*'])
            ->orderBy('name', 'asc')
            ->distinct()
            ->get();
    }

    /**
     * @param int $folderId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     * @author TrinhLe
     */
    public function getSharedFolders($userId, $folderId = 0)
    {

        return $this->model->join('media_folders', 'media_folders.id', '=', 'media_shares.share_id')
            ->where([
                'media_shares.share_type' => 'folder',
                'media_shares.shared_by' => $userId,
                'media_folders.parent_id' => $folderId,
            ])
            ->select(['media_shares.share_id', 'media_folders.*'])
            ->orderBy('name', 'asc')
            ->distinct()
            ->get();
    }

    /**
     * @param int $folderId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     * @author TrinhLe
     */
    public function getShareWithMeFiles($userId, $folderId = 0)
    {
        return $this->model->join('media_files', 'media_files.id', '=', 'media_shares.share_id')
            ->where([
                'media_shares.share_type' => 'file',
                'media_shares.user_id' => $userId,
                'media_files.folder_id' => $folderId,
            ])
            ->select(['media_shares.share_id', 'media_files.*'])
            ->orderBy('name', 'asc')
            ->distinct()
            ->get();
    }

    /**
     * @param int $folderId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     * @author TrinhLe
     */
    public function getSharedWithMeFolders($userId, $folderId = 0)
    {

        return $this->model->join('media_folders', 'media_folders.id', '=', 'media_shares.share_id')
            ->where([
                'media_shares.share_type' => 'folder',
                'media_shares.user_id'    => $userId,
                'media_folders.parent_id' => $folderId,
            ])
            ->select(['media_shares.share_id', 'media_folders.*'])
            ->orderBy('name', 'asc')
            ->distinct()
            ->get();
    }

    /**
     * @param $shareId
     * @param $shareType
     * @return mixed
     * @author TrinhLe
     */
    public function getSharedUsers($userId, $shareId, $shareType)
    {
        return $this->model->join('users', 'users.id', '=', 'media_shares.user_id')
            ->where([
                'shared_by'  => $userId,
                'share_type' => $shareType,
                'share_id'   => $shareId,
            ])
            ->selectRaw(config('media.user_attributes'))
            ->get();
    }
}