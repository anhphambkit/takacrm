<?php
namespace Core\Media\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface MediaShareRepositories extends RepositoryInterface
{
	/**
     * @param $folderId
     * @author TrinhLe
     */
    public function getSharedFiles($userId, $folderId = 0);

    /**
     * @param $folderId
     * @author TrinhLe
     */
    public function getSharedFolders($userId, $folderId = 0);

    /**
     * @param int $folderId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     * @author TrinhLe
     */
    public function getShareWithMeFiles($userId, $folderId = 0);

    /**
     * @param int $folderId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     * @author TrinhLe
     */
    public function getSharedWithMeFolders($userId, $folderId = 0);

    /**
     * @param $shareId
     * @param $shareType
     * @return mixed
     * @author TrinhLe
     */
    public function getSharedUsers($userId, $shareId, $shareType);    
}