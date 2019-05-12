<?php

namespace Core\Master\Facades;

use Core\Master\Supports\MailVariable;
use Illuminate\Support\Facades\Facade;

/**
 * Class MailVariableFacade
 * @package Core\Master
 */
class MailVariableFacade extends Facade
{
    /**
     * @return string
     * @author TrinhLe
     */
    protected static function getFacadeAccessor()
    {
        return MailVariable::class;
    }
}
