<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 10:42
 */

namespace Plugins\CustomAttributes\Services\Implement;

use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Repositories\Interfaces\AttributeValueStringRepositories;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;
use Plugins\CustomAttributes\Services\CustomAttributeServices;

class ImplementCustomAttributeServices implements CustomAttributeServices
{
    /**
     * @var CustomAttributesRepositories
     */
    private $customAttributesRepositories;

    /**
     * @var AttributeValueStringRepositories
     */
    private $attributeValueStringRepositories;

    /**
     * ImplementCustomAttributeServices constructor.
     * @param CustomAttributesRepositories $customAttributesRepositories
     * @param AttributeValueStringRepositories $attributeValueStringRepositories
     */
    public function __construct(CustomAttributesRepositories $customAttributesRepositories, AttributeValueStringRepositories $attributeValueStringRepositories)
    {
        $this->customAttributesRepositories = $customAttributesRepositories;
        $this->attributeValueStringRepositories = $attributeValueStringRepositories;
    }

    /**
     * @param int $attributeId
     * @return mixed
     */
    public function getAttributesValueByAttributeId(int $attributeId) {
        $attribute = $this->customAttributesRepositories->findById($attributeId);
        $result = [];
        if ($attribute) {
            $result = $this->getAttributesValueByAttributeIdAndTypeValue($attributeId, $attribute->type_value);
        }
        return $result;
    }

    /**
     * @param int $attributeId
     * @param string $typeValue
     * @return array
     */
    public function getAttributesValueByAttributeIdAndTypeValue(int $attributeId, string $typeValue) {
        $result = [];
        switch ($typeValue) {
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'):
                $result = $this->attributeValueStringRepositories->allBy([
                    [ 'custom_attribute_id', '=', $attributeId]
                ]);
                break;
        }
        return $result;
    }
}