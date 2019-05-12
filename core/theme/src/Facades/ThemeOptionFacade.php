<?php

namespace Core\Theme\Facades;

use Core\Theme\ThemeOption;
use Illuminate\Support\Facades\Facade;

class ThemeOptionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return ThemeOption::class;
    }
}
