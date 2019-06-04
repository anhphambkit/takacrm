<?php
/**
 * Created by PhpStorm.
 * User: Tu Nguyen
 * Date: 2019-05-24
 * Time: 08:48
 */

namespace Plugins\Order\DataTables;

use Plugins\Order\Repositories\Interfaces\PaymentMethodRepositories;
use Core\Base\DataTables\DataTableAbstract;

class PaymentMethodDataTable extends DataTableAbstract
{
    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Tu Nguyen
     */
    public function ajax()
    {
        $data = $this->datatables
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                return anchor_link(route('admin.payment.method.edit', $item->id), $item->name);
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
                return table_actions('admin.payment.method.edit', 'admin.payment.method.delete', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by datatables.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     * @author Tu Nguyen
     */
    public function query()
    {
        $model = app(PaymentMethodRepositories::class)->getModel();
        /**
         * @var \Eloquent $model
         */
        $query = $model->select(
            [
                'payment_method.id',
                'payment_method.slug',
                'payment_method.name',
                'payment_method.created_by',
                'payment_method.created_at',
                'payment_method.status'
            ]);
        return $query;
    }

    /**
     * @return array
     * @author Tu Nguyen
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id' => [
                'name' => 'payment_method.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'name' => [
                'name' => 'payment_method.name',
                'title' => trans('core-base::tables.name'),
                'footer' => trans('core-base::tables.name'),
                'class' => 'text-left searchable',
            ],
            'slug' => [
                'name' => 'payment_method.slug',
                'title' => trans('core-base::tables.slug'),
                'footer' => trans('core-base::tables.slug'),
                'class' => 'text-left searchable',
            ],
            'created_by' => [
                'name' => 'payment_method.created_by',
                'title' => trans('core-base::tables.created_by'),
                'footer' => trans('core-base::tables.created_by'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'payment_method.created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
            ],
            'status' => [
                'name' => 'payment_method.status',
                'title' => trans('core-base::tables.status'),
                'footer' => trans('core-base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array|mixed
     * @throws \Throwable
     */
    public function buttons()
    {
        $buttons = [
            'create' => [
                'link' => route('admin.payment.method.create'),
                'text' => view('core-base::elements.tables.actions.create')->render(),
            ],
        ];
        return $buttons;
    }

    /**
     * @return array
     * @author Tu Nguyen
     */
    public function actions()
    {
        return [];
    }

    /**
     * Get filename for export.
     *
     * @return string
     * @author Tu Nguyen
     */
    protected function filename()
    {
        return CUSTOMER_MODULE_SCREEN_NAME;
    }
}
