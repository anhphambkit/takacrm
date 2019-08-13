<?php

namespace Core\Master\Repositories\Cache;

use Core\Master\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Cache\Repository;
use Illuminate\Config\Repository as ConfigRepository;
use Exception;

abstract class CacheAbstractDecorator implements RepositoryInterface
{
    use CachePackageRepositoriesTrait;
    
    /**
     * @var \Packages\Core\Repositories\BaseRepository
     */
    protected $repository;

    /**
     * @var Repository
     */
    protected $cache;

    /**
     * @var Repository
     */
    protected $subDomain;
    
    /**
     * @var string The entity name
     */
    protected $entityName = 'default';

    /**
     * @var int caching time
     */
    protected $cacheTime;

    public function __construct()
    {
        $this->cache     = app(Repository::class);
        $this->cacheTime = app(ConfigRepository::class)->get('cache.time', 60);
        $this->subDomain = function_exists('get_sub_domain') ? get_sub_domain() : null;
    }

    /**
     * Get value function from repository if cache expired or invalid
     * @param $function
     * @param array $args
     * @return mixed
     * @author TrinhLe
     */
    public function getDataWithoutCache($function, array $args)
    {
        return call_user_func_array([$this->repository, $function], $args);
    }

    /**
     * @param $function
     * @param $args
     * @return mixed
     * @author TrinhLe
     */
    public function getDataIfExistCache($function, array $args)
    {
        try {
            $cacheKey = md5($this->subDomain . get_class($this) . $function . serialize(request()->input()) . serialize(func_get_args()));

            return $this->cache
            ->tags(["{$this->subDomain}_{$this->entityName}", 'global'])
            ->remember($cacheKey, $this->cacheTime,
                function () use ($function, $args){
                    return $this->getDataWithoutCache($function, $args);
                }
            );
           
        } catch (Exception $ex) {
            return $this->getDataWithoutCache($function, $args);
        }
    }

    /**
     * Clean cache and update data.
     * @param $function
     * @param $args
     * @param boolean $flushCache
     * @author TrinhLe
     * @return mixed
     */
    public function flushCacheAndUpdateData($function, $args, bool $flushCache = true)
    {
        if ($flushCache) {
            $this->cache->tags("{$this->subDomain}_{$this->entityName}")->flush();
        }

        return $this->getDataWithoutCache($function, $args);
    }
}
