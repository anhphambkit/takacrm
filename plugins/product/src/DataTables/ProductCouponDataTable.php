<?php

namespace Plugins\Product\DataTables;

use Plugins\Product\Repositories\Interfaces\ProductCouponRepositories;
use Core\Base\DataTables\DataTableAbstract;

class ProductCouponDataTable extends DataTableAbstract
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function ajax()
    {
        $data = $this->datatables
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                return anchor_link(route('admin.product.coupon.edit', $item->id), $item->name);
            })
            ->editColumn('created_by', function ($item) {
                return $item->createdByUser ? $item->createdByUser->getFullName() : '-';
            })
            ->editColumn('coupon_value', function ($item) {
                return number_format($item->coupon_value) . ($item->coupon_type ? ' %' : ' $');
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return table_status($item->status);
            })
            ->editColumn('qr_code', function ($item) {
                return \QrCode::generate($item->code);
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, CUSTOMER_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_actions('admin.product.coupon.edit', 'admin.product.coupon.delete', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @author TrinhLe
     */
    public function query()
    {
        $model = app(ProductCouponRepositories::class)->getModel();
        $table = $model->getTable();

        /**
         * @var \Eloquent $model
         */
        $query = $model->select(
            [
                "{$table}.id",
                "{$table}.code",
                "{$table}.name",
                "{$table}.number",
                "{$table}.created_by",
                "{$table}.created_at",
                "{$table}.status",
                "{$table}.coupon_type",
                "{$table}.coupon_value",
            ]);
        return $query;
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function columns()
    {
        $model = app(ProductCouponRepositories::class)->getModel();
        $table = $model->getTable();

        return [
            'qr_code' => [
                'title'      => __('QR code'),
                'width'      => '134px',
                'class'      => 'text-center',
                'orderable'  => false,
                'searchable' => false,
                'exportable' => false,
                'printable'  => false,
                'footer'     => __('QR code')
            ],
            'coupon_value' => [
                'name'   => "{$table}.coupon_value",
                'title'  => trans('Value'),
                'footer' => trans('Value'),
                'class'  => 'text-left',
            ],
            'created_by' => [
                'name' => "{$table}.created_by",
                'title' => trans('core-base::tables.created_by'),
                'footer' => trans('core-base::tables.created_by'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => "{$table}.created_at",
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
            ],
            'status' => [
                'name' => "{$table}.status",
                'title' => trans('core-base::tables.status'),
                'footer' => trans('core-base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function buttons()
    {
        $buttons = [
            'create' => [
                'link' => route('admin.product.coupon.create'),
                'text' => view('core-base::elements.tables.actions.create')->render(),
            ],
        ];
        return $buttons;
    }

    /**
     * @return array
     * @author TrinhLe
     */
    public function actions()
    {
        return [];
    }

    /**
     * Custom parameters
     * @return [type] [description]
     */
    public function getParameters():array
    {
        return array_merge(parent::getParameters(),[
            'autoWidth' => false
        ]);
    }

    /**
     * Get filename for export.
     *
     * @return string
     * @author TrinhLe
     */
    protected function filename()
    {
        return PRODUCT_MODULE_COUPON_SCREEN_NAME;
    }
}