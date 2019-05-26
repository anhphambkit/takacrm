<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 08:54
 */

namespace Plugins\CustomAttributes\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use AssetManager;
use AssetPipeline;
use Core\Setting\Services\ReferenceServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\DataTables\AttributeDataTable;
use Plugins\CustomAttributes\Repositories\Interfaces\AttributeValueStringRepositories;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;
use Plugins\CustomAttributes\Requests\AttributeValueRequest;
use Plugins\CustomAttributes\Services\CustomAttributeServices;

class AttributeController extends BaseAdminController
{
    /**
     * @var CustomAttributesRepositories
     */
    protected $customAttributesRepositories;

    /**
     * @var ReferenceServices
     */
    protected $referenceServices;

    /**
     * @var CustomAttributeServices
     */
    protected $customAttributeServices;

    /**
     * @var AttributeValueStringRepositories
     */
    protected $attributeValueStringRepositories;

    /**
     * AttributeController constructor.
     * @param CustomAttributesRepositories $customAttributesRepositories
     * @param ReferenceServices $referenceServices
     * @param CustomAttributeServices $customAttributeServices
     * @param AttributeValueStringRepositories $attributeValueStringRepositories
     */
    public function __construct(CustomAttributesRepositories $customAttributesRepositories, ReferenceServices $referenceServices,
                                CustomAttributeServices $customAttributeServices, AttributeValueStringRepositories $attributeValueStringRepositories)
    {
        $this->customAttributesRepositories = $customAttributesRepositories;
        $this->referenceServices = $referenceServices;
        $this->customAttributeServices = $customAttributeServices;
        $this->attributeValueStringRepositories = $attributeValueStringRepositories;
        parent::__construct();
    }

    /**
     * @param $attributeId
     * @return mixed
     */
    public function getList($attributeId)
    {
        $attribute = $this->customAttributesRepositories->findById($attributeId);
        if (!$attribute)
            abort(404);

        switch ($attribute->type_value) {
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'):
                $dataTable = app()->make(AttributeDataTable::class);
                break;
        }

        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.list'));
        $this->addManageAssets();
        return $dataTable->with(['id' => $attributeId, 'type_value' => $attribute->type_value, 'type_render' => $attribute->type_render ])->renderTable(['title' => trans('plugins-custom-attributes::custom-attributes.list')]);
    }

    /**
     * @param $attributeId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreate($attributeId)
    {
        $attribute = $this->customAttributesRepositories->findById((int)$attributeId);
        if (!$attribute)
            abort(404);

        $typeRender = $attribute->type_render;

        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.create'));
        $this->addDetailAssets();
        return view('plugins-custom-attributes::attribute.create', compact('attributeId', 'typeRender'));
    }

    /**
     * @param $attributeId
     * @param AttributeValueRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate($attributeId, AttributeValueRequest $request)
    {
        $data = $request->all();

        $data['custom_attribute_id'] = (int)$attributeId;
        $data['value'] = (!empty($request->value) ? $request->value : str_slug($data['name']));
        $data['created_by'] = Auth::id();

        $attribute = $this->attributeValueStringRepositories->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $attribute);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.custom-attributes.manage-attribute.list', [ 'attributeId' => $attributeId])->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.custom-attributes.manage-attribute.edit', [ 'attributeId' => $attributeId], $attribute->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * @param $attributeId
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEdit($attributeId, $id)
    {
        $attribute = $this->customAttributesRepositories->findById((int)$attributeId);
        if (!$attribute)
            abort(404);

        $typeRender = $attribute->type_render;

        $attributeValue = $this->attributeValueStringRepositories->findById($id);
        if (empty($attribute)) {
            abort(404);
        }
        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.edit') . ' #' . $id);
        $this->addDetailAssets();
        return view('plugins-custom-attributes::attribute.edit', compact('attributeValue', 'typeRender'));
    }

    /**
     * @param $attributeId
     * @param $id
     * @param AttributeValueRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($attributeId, $id, AttributeValueRequest $request)
    {
        $attribute = $this->attributeValueStringRepositories->findById($id);
        if (empty($attribute)) {
            abort(404);
        }

        $data = $request->all();
        $data['custom_attribute_id'] = (int)$attributeId;
        $data['value'] = (!empty($request->value) ? $request->value : str_slug($data['name']));
        $data['updated_by'] = Auth::id();
        $attribute->fill($data);

        $this->attributeValueStringRepositories->createOrUpdate($attribute);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $attribute);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.custom-attributes.manage-attribute.list', [ 'attributeId' => $attributeId])->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.custom-attributes.manage-attribute.edit', [ 'attributeId' => $attributeId], $id)->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param $attributeId
     * @param $id
     * @param Request $request
     * @return array
     */
    public function getDelete($attributeId, $id, Request $request)
    {
        try {
            $attribute = $this->attributeValueStringRepositories->findById($id);
            if (empty($attribute)) {
                abort(404);
            }
            $this->attributeValueStringRepositories->delete($attribute);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $attribute);

            return [
                'error' => false,
                'message' => trans('core-base::notices.deleted'),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => trans('core-base::notices.cannot_delete'),
            ];
        }
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addDetailAssets()
    {
        AssetManager::addAsset('select2-css', 'libs/plugins/product/css/select2/select2.min.css');

        AssetManager::addAsset('select2-js', 'libs/plugins/product/js/select2/select2.full.min.js');
        AssetManager::addAsset('cropper-js', '//cdnjs.cloudflare.com/ajax/libs/cropper/0.7.9/cropper.min.js');

        AssetPipeline::requireCss('select2-css');

        AssetPipeline::requireJs('select2-js');
        AssetPipeline::requireJs('cropper-js');

        AssetManager::addAsset('pretty-checkbox', 'https://cdnjs.cloudflare.com/ajax/libs/pretty-checkbox/3.0.0/pretty-checkbox.min.css');
        AssetPipeline::requireCss('pretty-checkbox');

        AssetManager::addAsset('product-color-css', 'backend/plugins/product/assets/css/product-color.css');
        AssetManager::addAsset('mini-colors-css', 'libs/plugins/product/css/miniColors/jquery.minicolors.css');
        AssetManager::addAsset('mini-colors-js', 'libs/plugins/product/js/miniColors/jquery.minicolors.min.js');
        AssetManager::addAsset('spectrum-js', 'libs/plugins/product/js/spectrum/spectrum.js');
        AssetManager::addAsset('picker-color-js', 'backend/plugins/product/assets/scripts/picker-color.min.js');

        AssetPipeline::requireCss('mini-colors-css');
        AssetPipeline::requireCss('product-color-css');
        AssetPipeline::requireJs('mini-colors-js');
        AssetPipeline::requireJs('spectrum-js');
        AssetPipeline::requireJs('picker-color-js');
    }

    /**
     * Add frontend plugins for layout
     * @author AnhPham
     */
    private function addManageAssets()
    {
        AssetManager::addAsset('custom-attributes-css', 'backend/plugins/custom-attributes/assets/css/custom-attributes.css');

        AssetPipeline::requireCss('custom-attributes-css');
    }
}