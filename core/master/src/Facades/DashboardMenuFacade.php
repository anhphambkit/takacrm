<?php

namespace Core\Master\Facades;

use Core\Master\Supports\DashboardMenu;
use Illuminate\Support\Facades\Facade;

/**
 * Class DashboardMenuFacade
 * @package Core\Master
 */
class DashboardMenuFacade extends Facade
{
    /**
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return DashboardMenu::class;
    }
}
