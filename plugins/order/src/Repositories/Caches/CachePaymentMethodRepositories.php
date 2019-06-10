<?php
namespace Plugins\Order\Repositories\Caches;
use Core\Master\Repositories\Cache\CacheAbstractDecorator;
use Plugins\Order\Repositories\Interfaces\PaymentMethodRepositories;

class CachePaymentMethodRepositories extends CacheAbstractDecorator implements PaymentMethodRepositories
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
    public function __construct(PaymentMethodRepositories $repository)
    {
        parent::__construct();
        $this->repository = $repository;
        $this->entityName = 'default'; # Please setup reference name of cache.
    }
}
