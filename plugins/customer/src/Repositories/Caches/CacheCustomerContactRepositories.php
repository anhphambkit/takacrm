<?php
namespace Plugins\Customer\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Customer\Repositories\Interfaces\CustomerContactRepositories;

class CacheCustomerContactRepositories extends CacheAbstractDecorator implements CustomerContactRepositories
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
    public function __construct(CustomerContactRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'default'; # Please setup reference name of cache.
    }
}
