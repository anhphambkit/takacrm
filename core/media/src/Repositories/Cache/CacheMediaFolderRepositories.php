<?php
namespace Core\Media\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\Media\Repositories\Interfaces\MediaFolderRepositories;

class CacheMediaFolderRepositories extends CacheAbstractDecorator implements MediaFolderRepositories
{
    /**
     * @var ApplicationInterface
     */
    protected $repository;

    /**
     * ApplicationCacheDecorator constructor.
     * @param ApplicationInterface $repository
     * @author TrinhLe
     */
    public function __construct(MediaFolderRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'core-media'; # Please setup reference name of cache.
    }

    /**
     * @param $folderId
     * @param array $params
     * @param bool $withTrash
     * @return mixed
     */
    public function getFolderByParentId($folderId, $userId, array $params = [], $withTrash = false)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param $name
     * @param $parentId
     * @return mixed
     * @author TrinhLe
     */
    public function createSlug($name, $parentId, $userId)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param $name
     * @param $parentId
     * @author TrinhLe
     * @return mixed
     */
    public function createName($name, $parentId, $userId)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param $parentId
     * @param array $breadcrumbs
     * @return array
     */
    public function getBreadcrumbs($parentId, $breadcrumbs = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param $parentId
     * @param array $params
     * @return mixed
     */
    public function getTrashed($parentId, $userId, array $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param $folderId
     * @param bool $force
     * @return mixed
     */
    public function deleteFolder($folderId, $userId, $force = false)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param $parentId
     * @param array $child
     * @return array
     * @internal param $folderId
     */
    public function getAllChildFolders($parentId, $child = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param $folderId
     * @param string $path
     * @return string
     * @author TrinhLe
     */
    public function getFullPath($folderId, $userId, $path = '')
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param $folderId
     * @internal param bool $force
     * @author TrinhLe
     */
    public function restoreFolder($folderId, $userId)
    {
        $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function emptyTrash($userId)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
