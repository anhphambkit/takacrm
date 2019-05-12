<?php
namespace Plugins\Blog\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Blog\Repositories\Interfaces\TagRepositories;

class CacheTagRepositories extends CacheAbstractDecorator implements TagRepositories
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
    public function __construct(TagRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'Plugin-Blog'; # Please setup reference name of cache.
    }
}
