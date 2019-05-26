<?php

namespace Plugins\CustomAttributes\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;

class CustomAttributesDataTable extends DataTableAbstract
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
                return anchor_link(route('admin.custom-attributes.edit', $item->id), $item->name);
            })
            ->editColumn('type_entity', function ($item) {
                return ucfirst($item->type_entity);
            })
            ->editColumn('type_render', function ($item) {
                return ucwords(str_replace('_', ' ', $item->type_render));
            })
            ->editColumn('is_required', function ($item) {
                return (!empty($item->is_required) ? 'True' : 'False');
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                return table_status($item->status);
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_attribute_actions('admin.custom-attributes.edit', 'admin.custom-attributes.delete', 'admin.custom-attributes.manage-attribute.list', $item);
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
       $model = app(CustomAttributesRepositories::class)->getModel();
       /**
        * @var \Eloquent $model
        */
       $query = $model->select([
           'custom_attributes.id',
           'custom_attributes.name',
           'custom_attributes.type_entity',
           'custom_attributes.type_render',
           'custom_attributes.is_required',
           'custom_attributes.created_at',
           'custom_attributes.status'
       ]);
       return $query;
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
                'name' => 'custom_attributes.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'name' => [
                'name' => 'custom_attributes.name',
                'title' => trans('core-base::tables.name'),
                'footer' => trans('core-base::tables.name'),
                'class' => 'text-left searchable',
            ],
            'type_entity' => [
                'name' => 'custom_attributes.type_entity',
                'title' => trans('plugins-custom-attributes::custom-attributes.form.type_entity'),
                'footer' => trans('plugins-custom-attributes::custom-attributes.form.type_entity'),
                'class' => 'text-left searchable',
            ],
            'type_render' => [
                'name' => 'custom_attributes.type_render',
                'title' => trans('plugins-custom-attributes::custom-attributes.form.type_render'),
                'footer' => trans('plugins-custom-attributes::custom-attributes.form.type_render'),
                'class' => 'text-left searchable',
            ],
            'is_required' => [
                'name' => 'custom_attributes.is_required',
                'title' => trans('plugins-custom-attributes::custom-attributes.form.is_required'),
                'footer' => trans('plugins-custom-attributes::custom-attributes.form.is_required'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'custom_attributes.created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
            ],
            'status' => [
                'name' => 'custom_attributes.status',
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
                'link' => route('admin.custom-attributes.create'),
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
        return CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME;
    }
}
