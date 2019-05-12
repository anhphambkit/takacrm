<?php

namespace Core\Media\Image\Intervention\Manipulations;

use Core\Media\Image\ImageHandlerInterface;

class Brightness implements ImageHandlerInterface
{
    private $defaults = [
        'level' => 1,
    ];

    /**
     * Handle the image manipulation request
     * @param  \Intervention\Image\Image $image
     * @param  array                     $options
     * @return \Intervention\Image\Image
     */
    public function handle($image, $options)
    {
        $options = array_merge($this->defaults, $options);

        return $image->brightness($options['level']);
    }
}
