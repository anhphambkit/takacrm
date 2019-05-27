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
     * @param array $data
     * @param null $customAttributeId
     * @return mixed
     */
    public function createOrUpdateCustomAttribute(array $data, $customAttributeId = null);

    /**
     * @param array $data
     * @param bool $isModeCreate
     * @return mixed
     */
    public function prepareDataForCreateOrUpdateCustomAttribute(array $data, bool $isModeCreate = true);

    /**
     * @param array $conditions
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function getAllCustomAttributeByConditions(array $conditions = [], array $with = [], array $select = ['*']);

    /**
     * @param array $conditions
     * @param array $with
     * @param array $select
     */
    public function parseRequestForCustomAttributeByConditions(array $conditions = [], array $with = [], array $select = ['*']);

    /**
     * @param $entity
     * @param $allEntityCustomAttributes
     * @param array $dataEntity
     */
    public function createOrUpdateDataEntityCustomAttributes(&$entity, $allEntityCustomAttributes, array $dataEntity);
}