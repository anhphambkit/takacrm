<?php

namespace Core\Media\Image\Intervention\Manipulations;

use Core\Media\Image\ImageHandlerInterface;

class Crop implements ImageHandlerInterface
{
    private $defaults = [
        'width' => '100',
        'height' => '100',
        'x' => null,
        'y' => null,
    ];

    /**
     * Handle the image manipulation request
     * @param  \Intervention\Image\Image $image
     * @param  array                     $options
     * @return mixed
     */
    public function handle($image, $options)
    {
        $options = array_merge($this->defaults, $options);

        return $image->crop($options['width'], $options['height'], $options['x'], $options['y']);
    }
}
