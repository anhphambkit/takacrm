<?php

namespace Core\Theme\Facades;

use Illuminate\Support\Facades\Facade;
use Core\Theme\Foundation\Asset\Pipeline\AssetPipeline;

class AssetPipelineFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return AssetPipeline::class;
    }
}
