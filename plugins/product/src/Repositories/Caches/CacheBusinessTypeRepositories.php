<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;

class CacheBusinessTypeRepositories extends CacheAbstractDecorator implements BusinessTypeRepositories
{
    /**
     * @var BusinessTypeRepositories
     */
    protected $repository;

    /**
     * CacheBusinessTypeRepositories constructor.
     * @param BusinessTypeRepositories $repository
     */
    public function __construct(BusinessTypeRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'business-repos'; # Please setup reference name of cache.
    }

    /**
     * @return mixed
     */
    public function getAllBusinessTypeGroupByParent() {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
