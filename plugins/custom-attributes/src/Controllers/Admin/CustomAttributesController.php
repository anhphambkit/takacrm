<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-18
 * Time: 15:35
 */

namespace Plugins\CustomAttributes\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use AssetManager;
use AssetPipeline;
use Core\Setting\Services\ReferenceServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\DataTables\CustomAttributesDataTable;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;
use Plugins\CustomAttributes\Requests\CustomAttributesRequest;
use Plugins\CustomAttributes\Services\CustomAttributeServices;

class CustomAttributesController extends BaseAdminController
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
     * CustomAttributesController constructor.
     * @param CustomAttributesRepositories $customAttributesRepositories
     * @param ReferenceServices $referenceServices
     * @param CustomAttributeServices $customAttributeServices
     */
    public function __construct(CustomAttributesRepositories $customAttributesRepositories, ReferenceServices $referenceServices, CustomAttributeServices $customAttributeServices)
    {
        $this->customAttributesRepositories = $customAttributesRepositories;
        $this->referenceServices = $referenceServices;
        $this->customAttributeServices = $customAttributeServices;
        parent::__construct();
    }

    /**
     * Display all color
     * @param CustomAttributesDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getList(CustomAttributesDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.list'));
        $this->addManageAssets();
        return $dataTable->renderTable(['title' => trans('plugins-custom-attributes::custom-attributes.list')]);
    }

    /**
     * @param $typeEntity
     * @param CustomAttributesDataTable $dataTable
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function getListByEntity($typeEntity, CustomAttributesDataTable $dataTable)
    {
        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.list'));
        $this->addManageAssets();
        return $dataTable->with('typeEntity', $typeEntity)->renderTable(['title' => trans('plugins-custom-attributes::custom-attributes.list')]);
    }

    /**
     * Show create form
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getCreate()
    {
        $typeEntities = $this->referenceServices->getReferenceFromAttributeType(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY)
            ->pluck('value', 'slug')
            ->toArray();

        $typeRenders = $this->referenceServices->getReferenceFromAttributeType(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER)
            ->pluck('value', 'slug')
            ->toArray();

        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.create'));
        $this->addDetailAssets();
        return view('plugins-custom-attributes::create', compact('typeEntities', 'typeRenders'));
    }

    /**
     * @param $typeEntity
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateByEntity($typeEntity)
    {
        $typeEntities = $this->referenceServices->getReferenceFromAttributeType(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY, ucfirst($typeEntity))
            ->pluck('value', 'slug')
            ->toArray();

        $typeRenders = $this->referenceServices->getReferenceFromAttributeType(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER)
            ->pluck('value', 'slug')
            ->toArray();

        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.create'));
        $this->addDetailAssets();
        return view("plugins-{$typeEntity}::custom-attributes.create", compact('typeEntity', 'typeEntities', 'typeRenders'));
    }

    /**
     * @param CustomAttributesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CustomAttributesRequest $request)
    {
        $customAttribute = $this->customAttributeServices->createOrUpdateCustomAttribute($request->all());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $customAttribute);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.custom-attributes.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.custom-attributes.edit', $customAttribute->id)->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * @param $typeEntity
     * @param CustomAttributesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreateByEntity($typeEntity, CustomAttributesRequest $request)
    {
        $customAttribute = $this->customAttributeServices->createOrUpdateCustomAttribute($request->all());

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $customAttribute);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.custom-attributes.entity.list', [ 'typeEntity' => $typeEntity ])->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.custom-attributes.entity.edit', [ 'typeEntity' => $typeEntity, 'id' => $customAttribute->id ])->with('success_msg', trans('core-base::notices.create_success_message'));
        }
    }

    /**
     * Show edit form
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author AnhPham
     */
    public function getEdit($id)
    {
        $customAttribute = $this->customAttributesRepositories->findById($id);
        if (empty($customAttribute)) {
            abort(404);
        }
        $typeEntities = $this->referenceServices->getReferenceFromAttributeType(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY)
            ->pluck('value', 'slug')
            ->toArray();

        $typeRenders = $this->referenceServices->getReferenceFromAttributeType(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER)
            ->pluck('value', 'slug')
            ->toArray();

        $attributeOptions = [];
        if ($customAttribute->attributeOptions() != null) {
            $attributeOptions = $customAttribute->attributeOptions()->select('option_text')->get()->pluck('option_text')->toArray();
        }

        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.edit') . ' #' . $id);
        $this->addDetailAssets();
        return view('plugins-custom-attributes::edit', compact('customAttribute', 'typeEntities', 'typeRenders', 'attributeOptions'));
    }

    /**
     * @param $typeEntity
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditByEntity($typeEntity, $id)
    {
        $customAttribute = $this->customAttributesRepositories->findById($id);
        if (empty($customAttribute)) {
            abort(404);
        }
        $typeEntities = $this->referenceServices->getReferenceFromAttributeType(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_ENTITY, ucfirst($typeEntity))
            ->pluck('value', 'slug')
            ->toArray();

        $typeRenders = $this->referenceServices->getReferenceFromAttributeType(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER)
            ->pluck('value', 'slug')
            ->toArray();

        $attributeOptions = [];
        if ($customAttribute->attributeOptions() != null) {
            $attributeOptions = $customAttribute->attributeOptions()->select('option_text')->get()->pluck('option_text')->toArray();
        }

        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.edit') . ' #' . $id);
        $this->addDetailAssets();
        return view("plugins-{$typeEntity}::custom-attributes.edit", compact('typeEntity','customAttribute', 'typeEntities', 'typeRenders', 'attributeOptions'));
    }

    /**
     * @param $id
     * @param CustomAttributesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, CustomAttributesRequest $request)
    {
        $customAttribute = $this->customAttributeServices->createOrUpdateCustomAttribute($request->all(), $id);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $customAttribute);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.custom-attributes.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.custom-attributes.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param $typeEntity
     * @param $id
     * @param CustomAttributesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEditByEntity($typeEntity, $id, CustomAttributesRequest $request)
    {
        $customAttribute = $this->customAttributeServices->createOrUpdateCustomAttribute($request->all(), $id);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $customAttribute);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.custom-attributes.entity.list', [ 'typeEntity' => $typeEntity ])->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.custom-attributes.entity.edit', [ 'typeEntity' => $typeEntity, 'id' => $id ])->with('success_msg', trans('core-base::notices.update_success_message'));
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array
     * @author AnhPham
     */
    public function getDelete(Request $request, $id)
    {
        try {
            $customAttribute = $this->customAttributesRepositories->findById($id);
            if (empty($customAttribute)) {
                abort(404);
            }
            $this->customAttributesRepositories->delete($customAttribute);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $customAttribute);

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
        AssetManager::addAsset('custom-attribute-js', 'backend/plugins/custom-attributes/assets/js/custom-attribute.js');

        AssetPipeline::requireCss('mini-colors-css');
        AssetPipeline::requireCss('product-color-css');
        AssetPipeline::requireJs('mini-colors-js');
        AssetPipeline::requireJs('spectrum-js');
        AssetPipeline::requireJs('picker-color-js');
        AssetPipeline::requireJs('custom-attribute-js');
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