<?php

namespace Core\Master\Facades;

use Core\Master\Supports\Filter;
use Illuminate\Support\Facades\Facade;

/**
 * Class FilterFacade
 * @package Core\Master
 */
class FilterFacade extends Facade
{
    /**
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return Filter::class;
    }
}
