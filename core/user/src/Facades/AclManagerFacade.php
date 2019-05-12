<?php

namespace Core\User\Facades;

use Core\User\AclManager;
use Illuminate\Support\Facades\Facade;

class AclManagerFacade extends Facade
{
    /**
     * {@inheritDoc}
     */
    protected static function getFacadeAccessor()
    {
        return AclManager::class;
    }
}
