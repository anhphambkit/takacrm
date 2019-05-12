<?php

namespace Core\Setting\Facades;

use Core\Setting\Setting;
use Illuminate\Support\Facades\Facade;

class SettingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return Setting::class;
    }
}
