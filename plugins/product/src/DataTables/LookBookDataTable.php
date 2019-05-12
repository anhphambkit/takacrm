<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-20
 * Time: 08:31
 */

namespace Plugins\Product\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;

class LookBookDataTable extends DataTableAbstract
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
                return anchor_link(route('admin.product.look_book.edit', $item->id), $item->name);
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
                return table_actions('admin.product.look_book.edit', 'admin.product.look_book.delete', $item);
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
        $model = app(LookBookRepositories::class)->getModel();
        /**
         * @var \Eloquent $model
         */
        $query = $model->select(
            [
                'look_books.id',
                'look_books.image',
                'look_books.name',
                'look_books.created_by',
                'look_books.created_at'
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
                'name' => 'look_books.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'image' => [
                'name' => 'look_books.image',
                'title' => trans('core-base::tables.image'),
                'footer' => trans('core-base::tables.image'),
                'class' => 'text-left',
                'width' => '60px',
                "render" => '"<img src=\"" + data + "\" height=\"50\"/>"',
            ],
            'name' => [
                'name' => 'look_books.name',
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
                'name' => 'look_books.created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
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
                'link' => route('admin.product.look_book.create'),
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