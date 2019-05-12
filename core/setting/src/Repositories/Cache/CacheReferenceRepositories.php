<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-30
 * Time: 09:14
 */

namespace Core\Setting\Repositories\Cache;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Core\Setting\Repositories\Interfaces\ReferenceRepositories;

class CacheReferenceRepositories extends CacheAbstractDecorator implements ReferenceRepositories
{
    /**
     * @var ReferenceRepositories
     */
    protected $repository;

    /**
     * CacheReferenceRepositories constructor.
     * @param ReferenceRepositories $repository
     */
    public function __construct(ReferenceRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'cache_reference'; # Please setup reference name of cache.
    }
}
