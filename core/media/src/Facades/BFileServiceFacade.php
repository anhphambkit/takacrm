<?php

namespace Core\Media\Facades;

use Illuminate\Support\Facades\Facade;
use Core\Media\Services\BFileService;

class BFileServiceFacade extends Facade
{
    /**
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return BFileService::class;
    }
}