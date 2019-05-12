<?php

namespace Plugins\Faq\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Faq\Repositories\Interfaces\FaqRepositories;

class CacheFaqRepositories extends CacheAbstractDecorator implements FaqRepositories
{
    /**
     * @var FaqRepositories
     */
    protected $repository;

    /**
     * FaqCacheDecorator constructor.
     * @param FaqRepositories $repository
     * @author TrinhLe
     */
    public function __construct(FaqRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-Faq"; # Please setup reference name of cache.
    }
}
