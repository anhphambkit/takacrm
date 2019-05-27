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
use Plugins\CustomAttributes\Models\CustomAttributeOptions;
use Plugins\CustomAttributes\Repositories\Interfaces\AttributeValueStringRepositories;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;
use Plugins\CustomAttributes\Services\CustomAttributeServices;
use Illuminate\Support\Facades\DB;

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
     * @param array $data
     * @param null $customAttributeId
     * @return mixed
     */
    public function createOrUpdateCustomAttribute(array $data, $customAttributeId = null)
    {
        $isModeCreate = true;
        if ($customAttributeId)
            $isModeCreate = false;

        $dataCustomAttribute = $this->prepareDataForCreateOrUpdateCustomAttribute($data, $isModeCreate);

        if ($isModeCreate) {
            $customAttribute = DB::transaction(function () use ($dataCustomAttribute) {
                $customAttribute = $this->customAttributesRepositories->createOrUpdateCustomAttribute($dataCustomAttribute);
                $customAttributeOptions = (isset($dataCustomAttribute['attribute_options']) ? $dataCustomAttribute['attribute_options'] : []);
                foreach ($customAttributeOptions as $customAttributeOption) {
                    $customAttribute->attributeOptions()->create([
                        'option_text' => $customAttributeOption,
                    ]);
                }
                $customAttribute->save();
                return $customAttribute;
            }, 3);
        }
        else {
            $customAttribute = $this->customAttributesRepositories->findById($customAttributeId);
            if (empty($customAttribute)) {
                abort(404);
            }
            $customAttribute = DB::transaction(function () use ($dataCustomAttribute, $customAttribute) {
                $customAttribute->fill($dataCustomAttribute);

                $this->customAttributesRepositories->createOrUpdate($customAttribute);

                CustomAttributeOptions::with('customAttribute')->where('custom_attribute_id', $customAttribute->id)->delete();
                $customAttributeOptions = (isset($dataCustomAttribute['attribute_options']) ? $dataCustomAttribute['attribute_options'] : []);
                foreach ($customAttributeOptions as $customAttributeOption) {
                    $customAttribute->attributeOptions()->create([
                        'option_text' => $customAttributeOption,
                    ]);
                }
                $customAttribute->save();
                return $customAttribute;
            }, 3);
        }
        return $customAttribute;
    }

    /**
     * @param array $data
     * @param bool $isModeCreate
     * @return array|mixed
     */
    public function prepareDataForCreateOrUpdateCustomAttribute(array $data, bool $isModeCreate = true) {
        $data['slug'] = str_slug($data['name']);
        $data['is_unique'] = !empty($data['is_unique']) ? $data['is_unique'] : false;
        $data['is_required'] = !empty($data['is_required']) ? $data['is_required'] : false;
        if ($isModeCreate)
            $data['created_by'] = Auth::id();
        else
            $data['updated_by'] = Auth::id();

        switch ($data['type_render']) {
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXTAREA, '_'):
                $data['type_value'] = CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_TEXT;
                break;
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_NUMBER_INPUT, '_'):
                $data['type_value'] = CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_NUMBER;
                break;
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_CHECKBOX, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_RADIO, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_SINGLE_SELECT, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_MULTIPLE_SELECT, '_'):
                $data['type_value'] = CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_OPTION;
                break;
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_DATE_TIME_INPUT, '_'):
                $data['type_value'] = CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_DATE;
                break;
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_URL_INPUT, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_TEXT_INPUT, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'):
                $data['type_value'] = CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_STRING;
                break;
            default:
                $data['type_value'] = CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_STRING;
                break;
        }
        return $data;
    }

    /**
     * @param array $conditions
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function getAllCustomAttributeByConditions(array $conditions = [], array $with = [], array $select = ['*']) {
        return $this->customAttributesRepositories->getAllCustomAttributeByConditions($conditions, $with, $select);
    }

    /**
     * @param array $conditions
     * @param array $with
     * @param array $select
     * @return array
     */
    public function parseRequestForCustomAttributeByConditions(array $conditions = [], array $with = [], array $select = ['*']) {
        $customAttributes = $this->getAllCustomAttributeByConditions($conditions, $with, $select);
        $request = [];
        foreach ($customAttributes as $customAttribute) {
            if ($customAttribute->type_render === str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_MULTIPLE_SELECT, '_') || $customAttribute->type_render === str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_CHECKBOX, '_')) {
                if ($customAttribute->is_required)
                    $request["cf_$customAttribute->slug"] = "required";
                if ($customAttribute->is_unique)
                    $request["cf_{$customAttribute->slug}.*"] = "unique:custom_attribute_value_{$customAttribute->type_value},value,{$customAttribute->id},custom_attribute_id,deleted_at,NULL";
            }
            else if ($customAttribute->type_render !== str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_DATE_TIME_INPUT, '_')) {
                if ($customAttribute->is_required && $customAttribute->is_unique)
                    $request["cf_$customAttribute->slug"] = "required|unique:custom_attribute_value_{$customAttribute->type_value},value,{$customAttribute->id},custom_attribute_id,deleted_at,NULL";
                else if ($customAttribute->is_required)
                    $request["cf_$customAttribute->slug"] = "required";
                else if ($customAttribute->is_unique)
                    $request["cf_$customAttribute->slug"] = "unique:custom_attribute_value_{$customAttribute->type_value},value,{$customAttribute->id},custom_attribute_id,deleted_at,NULL";
            }
            else {
//                if ($customAttribute->is_required && $customAttribute->is_unique)
//                    $request["cf_$customAttribute->slug"] = "required|unique:custom_attribute_value_{$customAttribute->type_value},value,{$customAttribute->id},custom_attribute_id,deleted_at,NULL";
                if ($customAttribute->is_required)
                    $request["cf_$customAttribute->slug"] = "required";
//                else if ($customAttribute->is_unique)
//                    $request["cf_$customAttribute->slug"] = "unique:custom_attribute_value_{$customAttribute->type_value},value,{$customAttribute->id},custom_attribute_id,deleted_at,NULL";
            }

            // validation type data
            switch ($customAttribute->type_value) {
                case CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_TEXT:
                    $request["cf_$customAttribute->slug"] .= '';
                    break;
                case CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_NUMBER:
                    $request["cf_$customAttribute->slug"] .= '|numeric';
                    break;
                case CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_OPTION:
                    $request["cf_$customAttribute->slug"] .= '';
                    break;
                case CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_DATE:
                    $request["cf_$customAttribute->slug"] .= '';
                    break;
                case CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_VALUE_STRING:
                    $request["cf_$customAttribute->slug"] .= '|max:255';
                    if ($customAttribute->type_render === str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_URL_INPUT, '_'))
                        $request["cf_$customAttribute->slug"] .= '|url';
                    break;
            }
        }
        return $request;
    }
}