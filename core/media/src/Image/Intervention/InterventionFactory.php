<?php

namespace Core\Media\Image\Intervention;

use Core\Media\Image\ImageFactoryInterface;

class InterventionFactory implements ImageFactoryInterface
{
    /**
     * @param  string                                     $manipulation
     * @return \Core\Media\Image\ImageHandlerInterface
     */
    public function make($manipulation)
    {
        $class = 'Core\\Media\\Image\\Intervention\\Manipulations\\' . ucfirst($manipulation);

        return new $class();
    }
}
