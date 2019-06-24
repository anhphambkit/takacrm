<?php

namespace Plugins\History\Repositories\Caches;

use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\History\Repositories\Interfaces\HistoryRepositories;

class CacheHistoryRepositories extends CacheAbstractDecorator implements HistoryRepositories
{
    /**
     * @var HistoryRepositories
     */
    protected $repository;

    /**
     * HistoryCacheDecorator constructor.
     * @param HistoryRepositories $repository
     * @author TrinhLe
     */
    public function __construct(HistoryRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = "Cache-History"; # Please setup reference name of cache.
    }
}
