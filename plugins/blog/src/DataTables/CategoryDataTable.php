<?php

namespace Plugins\Blog\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\Blog\Repositories\Interfaces\CategoryRepositories as CategoryInterface;

class CategoryDataTable extends DataTableAbstract
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
            ->of($this->query())
            ->editColumn('name', function ($item) {
                return anchor_link(route('admin.blog.category.edit', $item->id), $item->indent_text . ' ' . $item->name);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return table_status($item->status);
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, BLOG_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_actions('admin.blog.category.edit', 'admin.blog.category.delete', $item);
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
       return collect(get_categories([]));
    }

    /**
     * @return array
     * @author TrinhLe
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id' => [
                'name' => 'id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                // 'class' => 'searchable searchable_id',
            ],
            'name' => [
                'name' => 'name',
                'title' => trans('core-base::tables.name'),
                'footer' => trans('core-base::tables.name'),
                // 'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                // 'class' => 'searchable',
            ],
            'status' => [
                'name' => 'status',
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
                'link' => route('admin.blog.category.create'),
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
     * Get filename for export.
     *
     * @return string
     * @author TrinhLe
     */
    protected function filename()
    {
        return BLOG_CATEGORY_MODULE_SCREEN_NAME;
    }
}
