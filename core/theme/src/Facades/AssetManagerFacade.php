<?php

namespace Core\Theme\Facades;

use Core\Theme\Foundation\Asset\Manager\AssetManager;
use Illuminate\Support\Facades\Facade;

class AssetManagerFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return AssetManager::class;
    }
}
