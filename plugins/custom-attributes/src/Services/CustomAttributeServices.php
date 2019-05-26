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

    /**
     * @param $data
     * @return mixed
     */
    public function createOrUpdateCustomAttribute($data);

    /**
     * @param $data
     * @param bool $isModeCreate
     * @return mixed
     */
    public function prepareDataForCreateOrUpdateCustomAttribute($data, $isModeCreate = true);
}