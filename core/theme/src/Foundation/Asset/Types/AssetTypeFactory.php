<?php

namespace Core\Theme\Foundation\Asset\Types;

class AssetTypeFactory
{
    /**
     * @param $asset
     * @return \Core\Base\Foundation\Asset\Types\AssetType
     * @author TrinhLe
     * @throws \InvalidArgumentException
     */
    public function make($asset)
    {
        $typeClass = 'Core\Theme\Foundation\Asset\Types\\' . ucfirst(key($asset)) . 'Asset';

        if (class_exists($typeClass) === false) {
            throw new \InvalidArgumentException("Asset Type Class [$typeClass] not found");
        }

        return (new $typeClass($asset));
    }
}
