<?php

namespace Core\Master\Facades;

use Illuminate\Support\Facades\Facade;
use Core\Master\Supports\PageTitle;

class PageTitleFacade extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return PageTitle::class;
    }
}
