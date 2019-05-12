<?php
namespace Plugins\Product\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;

class CacheLookBookRepositories extends CacheAbstractDecorator implements LookBookRepositories
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
    public function __construct(LookBookRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'look-book-repo'; # Please setup reference name of cache.
    }

    /**
     * @param string $type
     * @param bool $isMain
     * @param int $take
     * @param array $businessTypes
     * @param array $spaces
     * @param array $exceptBusinessType
     * @return mixed
     */
    public function getAllLookBookByTypeLayout(string $type, bool $isMain = false, int $take = 0, array $businessTypes = [], array $spaces = [], array $exceptBusinessType = []) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
