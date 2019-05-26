<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 10:42
 */

namespace Plugins\CustomAttributes\Services\Implement;

use Illuminate\Support\Facades\Auth;
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
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXT_INPUT, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'):
                $result = $this->attributeValueStringRepositories->allBy([
                    [ 'custom_attribute_id', '=', $attributeId]
                ]);
                break;
        }
        return $result;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function createOrUpdateCustomAttribute($data)
    {
        $dataCustomAttribute = $this->prepareDataForCreateOrUpdateCustomAttribute($data);
        return $this->customAttributesRepositories->createOrUpdateCustomAttribute($dataCustomAttribute);
    }

    /**
     * @param $data
     * @param bool $isModeCreate
     * @return mixed
     */
    public function prepareDataForCreateOrUpdateCustomAttribute($data, $isModeCreate = true) {
        $data['slug'] = str_slug($data['name']);
        $data['is_unique'] = !empty($data['is_unique']) ? $data['is_unique'] : false;
        $data['is_required'] = !empty($data['is_required']) ? $data['is_required'] : false;
        if ($isModeCreate)
            $data['created_by'] = Auth::id();
        else
            $data['updated_by'] = Auth::id();

        switch ($data['type_render']) {
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXTAREA, '_'):
                $data['type_value'] = 'text';
                break;
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_NUMBER_INPUT, '_'):
                $data['type_value'] = 'number';
                break;
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_CHECKBOX, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_RADIO, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_SINGLE_SELECT, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_MULTIPLE_SELECT, '_'):
                $data['type_value'] = 'options';
                break;
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_DATE_TIME_INPUT, '_'):
                $data['type_value'] = 'date_time';
                break;
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_URL_INPUT, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXT_INPUT, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'):
                $data['type_value'] = 'string';
                break;
            default:
                $data['type_value'] = 'string';
                break;
        }
        return $data;
    }
}