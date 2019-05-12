<?php
namespace Core\Base\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\Base\Repositories\Interfaces\PluginRepositories;

class CachePluginRepositories extends CacheAbstractDecorator implements PluginRepositories
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
    public function __construct(PluginRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'default'; # Please setup reference name of cache.
    }
}
