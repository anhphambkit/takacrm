<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-13
 * Time: 05:19
 */

namespace Plugins\Product\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\Product\Models\ProductCategory;

class ProductCategoryDataTable extends DataTableAbstract
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
                return anchor_link(route('admin.product.category.edit', $item->id), $item->name);
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
                return table_actions('admin.product.category.edit', 'admin.product.category.delete', $item);
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
        $model = app(ProductCategory::class)->getModel();
        /**
         * @var \Eloquent $model
         */
        $query = $model->select(
            [
                'product_categories.id',
                'product_categories.name',
                'product_categories.slug',
                'product_categories.created_by',
                'product_categories.created_at',
                'product_categories.status'
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
                'name' => 'product_categories.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'name' => [
                'name' => 'product_categories.name',
                'title' => trans('core-base::tables.name'),
                'footer' => trans('core-base::tables.name'),
                'class' => 'text-left searchable',
            ],
            'slug' => [
                'name' => 'product_categories.slug',
                'title' => trans('core-base::tables.slug'),
                'footer' => trans('core-base::tables.slug'),
                'class' => 'text-left searchable',
            ],
            'created_by' => [
                'name' => 'products.created_by',
                'title' => trans('core-base::tables.created_by'),
                'footer' => trans('core-base::tables.created_by'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'product_categories.created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
            ],
            'status' => [
                'name' => 'product_categories.status',
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
                'link' => route('admin.product.category.create'),
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