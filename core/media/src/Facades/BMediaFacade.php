<?php

namespace Core\Media\Facades;

use Core\Media\BMedia;
use Illuminate\Support\Facades\Facade;

class BMediaFacade extends Facade
{
    /**
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return BMedia::class;
    }
}