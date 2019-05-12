<?php
namespace Core\Media\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\Media\Repositories\Interfaces\MediaShareRepositories;

class CacheMediaShareRepositories extends CacheAbstractDecorator implements MediaShareRepositories
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
    public function __construct(MediaShareRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'core-media'; # Please setup reference name of cache.
    }

    /**
     * @param $folderId
     * @return mixed
     * @author TrinhLe
     */
    public function getSharedFiles($userId, $folderId = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param $folderId
     * @return mixed
     * @author TrinhLe
     */
    public function getSharedFolders($userId, $folderId = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $folderId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     * @author TrinhLe
     */
    public function getShareWithMeFiles($userId, $folderId = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $folderId
     * @return array|\Illuminate\Database\Eloquent\Collection|static[]
     * @author TrinhLe
     */
    public function getSharedWithMeFolders($userId, $folderId = 0)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param $shareId
     * @param $shareType
     * @return mixed
     * @author TrinhLe
     */
    public function getSharedUsers($userId, $shareId, $shareType)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
