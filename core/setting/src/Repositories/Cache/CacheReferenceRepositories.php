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

    /**
     * @param $table
     * @param $where
     * @param bool $isUnique
     * @param string $orderBy
     * @return mixed
     */
    public function getReferenceFromAttribute($table, $where, $isUnique = false, $orderBy = 'id') {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * @param string $type
     * @param string|null $value
     * @return mixed
     */
    public function getReferenceFromAttributeType(string $type, string $value = null) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
