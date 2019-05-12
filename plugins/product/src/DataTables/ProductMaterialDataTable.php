<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-11
 * Time: 02:54
 */

namespace Plugins\Product\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\Product\Repositories\Interfaces\ProductMaterialRepositories;

class ProductMaterialDataTable extends DataTableAbstract
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author AnhPham
     */
    public function ajax()
    {
        $data = $this->datatables
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                return anchor_link(route('admin.product.material.edit', $item->id), $item->name);
            })
            ->editColumn('created_by', function ($item) {
                return $item->createdByUser ? $item->createdByUser->getFullName() : null;
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return table_status($item->status);
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, CUSTOMER_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_actions('admin.product.material.edit', 'admin.product.material.delete', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @author AnhPham
     */
    public function query()
    {
        $model = app(ProductMaterialRepositories::class)->getModel();
        /**
         * @var \Eloquent $model
         */
        $query = $model->select(
            [
                'product_materials.id',
                'product_materials.name',
                'product_materials.created_by',
                'product_materials.created_at',
                'product_materials.status'
            ]);
        return $query;
    }

    /**
     * @return array
     * @author AnhPham
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id' => [
                'name' => 'product_materials.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'name' => [
                'name' => 'product_materials.name',
                'title' => trans('core-base::tables.name'),
                'footer' => trans('core-base::tables.name'),
                'class' => 'text-left searchable',
            ],
            'created_by' => [
                'name' => 'products.created_by',
                'title' => trans('core-base::tables.created_by'),
                'footer' => trans('core-base::tables.created_by'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'product_materials.created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
            ],
            'status' => [
                'name' => 'product_materials.status',
                'title' => trans('core-base::tables.status'),
                'footer' => trans('core-base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     * @author AnhPham
     */
    public function buttons()
    {
        $buttons = [
            'create' => [
                'link' => route('admin.product.material.create'),
                'text' => view('core-base::elements.tables.actions.create')->render(),
            ],
        ];
        return $buttons;
    }

    /**
     * @return array
     * @author AnhPham
     */
    public function actions()
    {
        return [];
    }

    /**
     * Get filename for export.
     *
     * @return string
     * @author AnhPham
     */
    protected function filename()
    {
        return CUSTOMER_MODULE_SCREEN_NAME;
    }
}