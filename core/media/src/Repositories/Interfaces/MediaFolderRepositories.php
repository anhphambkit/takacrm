<?php
namespace Core\Media\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface MediaFolderRepositories extends RepositoryInterface
{
	/**
     * @param $folderId
     * @param array $params
     * @param bool $withTrash
     * @return mixed
     */
    public function getFolderByParentId($folderId, $userId, array $params = [], $withTrash = false);

    /**
     * @param $name
     * @param $parentId
     * @return
     * @author TrinhLe
     */
    public function createSlug($name, $parentId, $userId);

    /**
     * @param $name
     * @param $parentId
     * @author TrinhLe
     */
    public function createName($name, $parentId, $userId);

    /**
     * @param $parentId
     * @param array $breadcrumbs
     * @return array
     */
    public function getBreadcrumbs($parentId, $breadcrumbs = []);

    /**
     * @param $parentId
     * @param array $params
     * @return mixed
     */
    public function getTrashed($parentId, $userId, array $params = []);

    /**
     * @param $folderId
     * @param bool $force
     */
    public function deleteFolder($folderId, $userId, $force = false);

    /**
     * @param $parentId
     * @param array $child
     * @return array
     */
    public function getAllChildFolders($parentId, $child = []);

    /**
     * @param $folderId
     * @param string $path
     * @return string
     * @author TrinhLe
     */
    public function getFullPath($folderId, $userId, $path = '');

    /**
     * @param $folderId
     * @author TrinhLe
     */
    public function restoreFolder($folderId, $userId);

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function emptyTrash($userId);
}
