<?php

namespace Plugins\Blog\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Blog\Repositories\Interfaces\BlogRepositories;

class CacheBlogRepositories extends CacheAbstractDecorator implements BlogRepositories
{
    /**
     * @var BlogRepositories
     */
    protected $repository;

    /**
     * BlogCacheDecorator constructor.
     * @param BlogRepositories $repository
     * @author TrinhLe
     */
    public function __construct(BlogRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Plugin-Blog"; # Please setup reference name of cache.
    }
}
