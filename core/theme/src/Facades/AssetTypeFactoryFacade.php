<?php

namespace Core\Theme\Facades;

use Core\Theme\Foundation\Asset\Types\AssetTypeFactory;
use Illuminate\Support\Facades\Facade;

class AssetTypeFactoryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return AssetTypeFactory::class;
    }
}
