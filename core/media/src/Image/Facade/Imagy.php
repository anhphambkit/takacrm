<?php

namespace Core\Media\Image\Facade;

use Illuminate\Support\Facades\Facade;

class Imagy extends Facade
{	
	/**
	 * Register handle facade
	 * @author  TrinhLe
	 * @return Imagy
	 */
    protected static function getFacadeAccessor()
    {
        return 'imagy';
    }
}
