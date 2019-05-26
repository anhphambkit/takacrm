<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-19
 * Time: 08:54
 */

namespace Plugins\CustomAttributes\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\CustomAttributes\Contracts\CustomAttributeConfig;
use Plugins\CustomAttributes\Repositories\Interfaces\AttributeValueStringRepositories;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;
use Plugins\CustomAttributes\Services\CustomAttributeServices;

class AttributeDataTable extends DataTableAbstract
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
                return anchor_link(route("admin.custom-attributes.manage-attribute.edit", [ 'attributeId' => $this->id, 'id' => $item->id]), $item->name);
            })
            ->editColumn('value', function ($item) {
                if ($this->type_render === str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'))
                    return "<span class='minicolor-preview'><span class='minicolor-square-box' style='background-color: {$item->value};'></span></span><span class='product-color-attr'>{$item->value}</span>";
                else
                    return $item->value;
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

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, CUSTOM_ATTRIBUTES_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_attribute_value_actions(route('admin.custom-attributes.manage-attribute.edit', [ 'attributeId' => $this->id, 'id' => $item->id ]), route('admin.custom-attributes.manage-attribute.delete', [ 'attributeId' => $this->id, 'id' => $item->id ]), $item);
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
        switch ($this->type_value) {
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'):
                $model = app(AttributeValueStringRepositories::class)->getModel();
                $query = $model->select(
                    [
                    'attribute_value_string.id',
                    'attribute_value_string.custom_attribute_id',
                    'attribute_value_string.value',
                    'attribute_value_string.name',
                    'attribute_value_string.created_at',
                    'attribute_value_string.created_by',
                    'attribute_value_string.status'
                    ])->where('custom_attribute_id', '=', $this->id);
                break;
        }
        return $query;
    }

    /**
     * @return array
     * @author TrinhLe
     * @since 2.1
     */
    public function columns()
    {
        $columns = [];
        switch ($this->type_value) {
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_STRING, '_'):
            case str_slug(CustomAttributeConfig::REFERENCE_CUSTOM_ATTRIBUTE_TYPE_RENDER_COLOR_PICKER, '_'):
                $columns = $this->getColumnsAttributeValueString();
                break;
        }
        return $columns;
    }

    /**
     * @return array
     */
    public function getColumnsAttributeValueString() {
        return [
            'id' => [
                'name' => 'attribute_value_string.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'name' => [
                'name' => 'attribute_value_string.name',
                'title' => trans('core-base::tables.name'),
                'footer' => trans('core-base::tables.name'),
                'class' => 'text-left searchable',
            ],
            'value' => [
                'name' => 'attribute_value_string.value',
                'title' => trans('core-base::tables.value'),
                'footer' => trans('core-base::tables.value'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'attribute_value_string.created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
            ],
            'created_by' => [
                'name' => 'attribute_value_string.created_by',
                'title' => trans('core-base::tables.created_by'),
                'footer' => trans('core-base::tables.created_by'),
                'class' => 'text-left searchable',
            ],
            'status' => [
                'name' => 'attribute_value_string.status',
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
                'link' => route('admin.custom-attributes.manage-attribute.create', [ 'attributeId' => $this->id ]),
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
