<?php
namespace Core\Media\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\Media\Repositories\Interfaces\MediaSettingRepositories;

class CacheMediaSettingRepositories extends CacheAbstractDecorator implements MediaSettingRepositories
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
    public function __construct(MediaSettingRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'core-media'; # Please setup reference name of cache.
    }
}
