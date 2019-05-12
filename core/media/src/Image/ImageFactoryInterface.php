<?php

namespace Core\Media\Image;

interface ImageFactoryInterface
{
    /**
     * Return a new Manipulation class
     * @param  string                                     $manipulation
     * @return \Core\Media\Image\ImageHandlerInterface
     */
    public function make($manipulation);
}
