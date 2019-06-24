<?php
namespace Plugins\CustomAttributes\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\CustomAttributes\Repositories\Interfaces\AttributeValueStringRepositories;

class CacheAttributeValueStringRepositories extends CacheAbstractDecorator implements AttributeValueStringRepositories
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
    public function __construct(AttributeValueStringRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'default'; # Please setup reference name of cache.
    }
}
