<?php

namespace Plugins\Newsletter\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Newsletter\Repositories\Interfaces\NewsletterRepositories;

class CacheNewsletterRepositories extends CacheAbstractDecorator implements NewsletterRepositories
{
    /**
     * @var NewsletterRepositories
     */
    protected $repository;

    /**
     * NewsletterCacheDecorator constructor.
     * @param NewsletterRepositories $repository
     * @author TrinhLe
     */
    public function __construct(NewsletterRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Newsletter"; # Please setup reference name of cache.
    }
}
