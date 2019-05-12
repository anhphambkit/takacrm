<?php
namespace Core\Media\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface MediaFileRepositories extends RepositoryInterface
{
	/**
     * @return mixed
     * @author TrinhLe
     */
    public function getSpaceUsed($userId);

    /**
     * @return mixed
     */
    public function getSpaceLeft($userId);

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getQuota($userId);

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getPercentageUsed($userId);

    /**
     * @param $name
     * @param $folder
     * @author TrinhLe
     */
    public function createName($name, $folder, $userId);

    /**
     * @param $name
     * @param $extension
     * @param $folder
     * @author TrinhLe
     */
    public function createSlug($name, $extension, $folder);

    /**
     * @param $folderId
     * @param array $params
     * @return mixed
     */
    public function getFilesByFolderId($folderId, $userId, array $params = []);

    /**
     * @param $folderId
     * @param array $params
     * @return mixed
     */
    public function getTrashed($folderId, $userId, array $params = []);

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function emptyTrash($userId);    
}