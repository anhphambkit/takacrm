<?php

namespace Core\Media\Image\Intervention\Manipulations;

use Core\Media\Image\ImageHandlerInterface;

class Blur implements ImageHandlerInterface
{
    private $defaults = [
        'amount' => 1,
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

        return $image->blur($options['amount']);
    }
}
