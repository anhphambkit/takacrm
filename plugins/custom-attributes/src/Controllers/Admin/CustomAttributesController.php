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

class CustomAttributesController extends BaseAdminController
{
    /**
     * @var CustomAttributesRepositories
     */
    protected $productColorRepository;

    /**
     * @var ReferenceServices
     */
    protected $referenceServices;

    /**
     * CustomAttributesController constructor.
     * @param CustomAttributesRepositories $productColorRepository
     * @param ReferenceServices $referenceServices
     */
    public function __construct(CustomAttributesRepositories $productColorRepository, ReferenceServices $referenceServices)
    {
        $this->productColorRepository = $productColorRepository;
        $this->referenceServices = $referenceServices;
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
     * @param CustomAttributesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postCreate(CustomAttributesRequest $request)
    {
        $data = $request->all();

        $data['slug'] = str_slug($data['name']);
        $data['created_by'] = Auth::id();
        $data['type_value'] = str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING, '_');

        $color = $this->productColorRepository->createOrUpdate($data);

        do_action(BASE_ACTION_AFTER_CREATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $color);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.custom-attributes.list')->with('success_msg', trans('core-base::notices.create_success_message'));
        } else {
            return redirect()->route('admin.custom-attributes.edit', $color->id)->with('success_msg', trans('core-base::notices.create_success_message'));
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
        $color = $this->productColorRepository->findById($id);
        if (empty($color)) {
            abort(404);
        }
        page_title()->setTitle(trans('plugins-custom-attributes::custom-attributes.edit') . ' #' . $id);
        $this->addDetailAssets();
        return view('plugins-custom-attributes::custom-attributes.edit', compact('color'));
    }

    /**
     * @param $id
     * @param CustomAttributesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postEdit($id, CustomAttributesRequest $request)
    {
        $color = $this->productColorRepository->findById($id);
        if (empty($color)) {
            abort(404);
        }
        $color->fill(array($request->input(), ['updated_by' => Auth::id()]));

        $this->productColorRepository->createOrUpdate($color);

        do_action(BASE_ACTION_AFTER_UPDATE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $color);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.custom-attributes.list')->with('success_msg', trans('core-base::notices.update_success_message'));
        } else {
            return redirect()->route('admin.custom-attributes.edit', $id)->with('success_msg', trans('core-base::notices.update_success_message'));
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
            $color = $this->productColorRepository->findById($id);
            if (empty($color)) {
                abort(404);
            }
            $this->productColorRepository->delete($color);

            do_action(BASE_ACTION_AFTER_DELETE_CONTENT, PRODUCT_MODULE_SCREEN_NAME, $request, $color);

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