<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 10:41
 */

namespace Plugins\CustomAttributes\Services;


interface CustomAttributeServices
{
    /**
     * @param int $attributeId
     * @return mixed
     */
    public function getAttributesValueByAttributeId(int $attributeId);

    /**
     * @param int $attributeId
     * @param string $typeValue
     * @return array
     */
    public function getAttributesValueByAttributeIdAndTypeValue(int $attributeId, string $typeValue);
}