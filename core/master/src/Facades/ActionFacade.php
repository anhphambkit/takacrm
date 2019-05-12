<?php

namespace Core\Master\Facades;

use Core\Master\Supports\Action;
use Illuminate\Support\Facades\Facade;

/**
 * Class ActionFacade
 * @package Core\Master
 */
class ActionFacade extends Facade
{
    /**
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return Action::class;
    }
}
