<?php
namespace Core\Media\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\Media\Repositories\Interfaces\MediaFileRepositories;

class CacheMediaFileRepositories extends CacheAbstractDecorator implements MediaFileRepositories
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
    public function __construct(MediaFileRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'core-media'; # Please setup reference name of cache.
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getSpaceUsed($userId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getSpaceLeft($userId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getQuota($userId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getPercentageUsed($userId)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param $name
     * @param $folder
     * @return mixed
     * @author TrinhLe
     */
    public function createName($name, $folder)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param $name
     * @param $extension
     * @param $folder
     * @return mixed
     * @author TrinhLe
     */
    public function createSlug($name, $extension, $folder)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param $folderId
     * @param array $params
     * @return mixed
     * @author TrinhLe
     */
    public function getFilesByFolderId($folderId, $userId, array $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function emptyTrash($userId)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * @param $folderId
     * @param array $params
     * @return mixed
     */
    public function getTrashed($folderId, $userId, array $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
