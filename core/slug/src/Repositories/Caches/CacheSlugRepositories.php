<?php
namespace Core\Slug\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\Slug\Repositories\Interfaces\SlugRepositories;

class CacheSlugRepositories extends CacheAbstractDecorator implements SlugRepositories
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
    public function __construct(SlugRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'Core-Slug'; # Please setup reference name of cache.
    }
}
