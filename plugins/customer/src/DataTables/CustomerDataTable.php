<?php

namespace Plugins\Customer\DataTables;

use Core\Base\DataTables\DataTableAbstract;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;

class CustomerDataTable extends DataTableAbstract
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
                return anchor_link(route('admin.customer.detail', $item->id), $item->name);
            })
            ->editColumn('created_by', function ($item) {
                return $item->createdByUser ? $item->createdByUser->getFullName() : null;
            })
            ->editColumn('user_manage', function ($item) {
                return $item->userManage ? $item->userManage->getFullName() : null;
            })
            ->editColumn('introduce_person', function ($item) {
                return $item->getIntroducePerson() ? $item->getIntroducePerson() : null;
            })
            ->editColumn('customer_relation', function ($item) {
                return $item->customerRelationData
                    ? "<span class=\"minicolor-preview\">
                           <span class=\"minicolor-square-box\" style=\"background-color: {$item->customerRelationData->color_code};\"></span>
                       </span>
                       <span class=\"customer-color-attr\">{$item->customerRelationData->name}</span>"
                    : null;
            })
            ->editColumn('customer_group', function ($item) {
                $result = "";
                foreach ($item->customerGroups as $index => $customerGroup) {
                    $result .= "{$customerGroup->name}";
                    if ($index < $item->customerGroups->count() -1)
                        $result .= ", <br />";
                }
                return trim($result);
            })
            ->editColumn('customer_job', function ($item) {
                $result = "";
                foreach ($item->customerJobs as $index => $customerJob) {
                    $result .= "{$customerJob->name}";
                    if ($index < $item->customerJobs->count() -1)
                        $result .= ", <br />";
                }
                return trim($result);
            })
            ->editColumn('customer_source', function ($item) {
                $result = "";
                foreach ($item->customerSources as $index => $customerSource) {
                    $result .= "{$customerSource->name}";
                    if ($index < $item->customerSources->count() -1)
                        $result .= ", <br />";
                }
                return trim($result);
            })
            ->editColumn('ward_code', function ($item) {
                return $item->wardName ? $item->wardName->name : null;
            })
            ->editColumn('province_city_code', function ($item) {
                return $item->provinceCityName ? $item->provinceCityName->name : null;
            })
            ->editColumn('district_code', function ($item) {
                return $item->districtName ? $item->districtName->name : null;
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core-base.cms.date_format.date_time'));
            })
            ->editColumn('status', function ($item) {
                return table_status($item->status);
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, CUSTOMER_MODULE_SCREEN_NAME)
            ->addColumn('operations', function ($item) {
                return table_customer_actions('admin.customer.detail', 'admin.customer.edit', 'admin.customer.delete', $item);
            }, 2)
            ->addColumn('checkbox', function ($item) {
                return table_customer_checkbox($item->id, $item->customerRelationData->color_code);
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
       $model = app(CustomerRepositories::class)->getModel();
       /**
        * @var \Eloquent $model
        */
       $query = $model->select([
           'customers.id',
           'customers.full_name',
           'customers.gender',
           'customers.customer_code',
           'customers.tax_code',
           'customers.phone',
           'customers.fax',
           'customers.email',
           'customers.value',
           'customers.avatar',
           'customers.dob',
           'customers.address',
           'customers.province_city_code',
           'customers.district_code',
           'customers.ward_code',
           'customers.website',
           'customers.facebook',
           'customers.note',
           'type_reference_data',
           'introduce_person_id',
           'user_manage_id',
           'customers.created_by',
           'customers.customer_relationship_id',
           'customers.created_at',
           'customers.status'
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
            'checkbox' => [
                'class' => 'text-test',
                'bgcolor' => 'red'
            ],
            'id' => [
                'name' => 'customers.id',
                'title' => trans('core-base::tables.id'),
                'footer' => trans('core-base::tables.id'),
                'width' => '20px',
                'class' => 'searchable searchable_id',
            ],
            'operations' => [
                'class' => 'text-left',
            ],
            'status' => [
                'name' => 'customers.status',
                'title' => trans('core-base::tables.status'),
                'footer' => trans('core-base::tables.status'),
                'width' => '60px',
            ],
            'full_name' => [
                'name' => 'customers.full_name',
                'title' => trans('plugins-customer::customer.form.full_name'),
                'footer' => trans('plugins-customer::customer.form.full_name'),
                'class' => 'text-left searchable',
            ],
            'avatar' => [
                'name' => 'customers.avatar',
                'title' => trans('plugins-customer::customer.form.avatar'),
                'footer' => trans('plugins-customer::customer.form.avatar'),
                'class' => 'text-left',
                'width' => '60px',
                "render" => '"<img src=\"" + data + "\" height=\"50\"/>"',
            ],
            'gender' => [
                'name' => 'customers.gender',
                'title' => trans('plugins-customer::customer.form.gender'),
                'footer' => trans('plugins-customer::customer.form.gender'),
                'class' => 'text-left searchable',
            ],
            'customer_code' => [
                'name' => 'customers.customer_code',
                'title' => trans('plugins-customer::customer.form.customer_code'),
                'footer' => trans('plugins-customer::customer.form.customer_code'),
                'class' => 'text-left searchable',
            ],
            'phone' => [
                'name' => 'customers.phone',
                'title' => trans('plugins-customer::customer.form.phone'),
                'footer' => trans('plugins-customer::customer.form.phone'),
                'class' => 'text-left searchable',
            ],
            'fax' => [
                'name' => 'customers.fax',
                'title' => trans('plugins-customer::customer.form.fax'),
                'footer' => trans('plugins-customer::customer.form.fax'),
                'class' => 'text-left searchable',
            ],
            'email' => [
                'name' => 'customers.email',
                'title' => trans('plugins-customer::customer.form.email'),
                'footer' => trans('plugins-customer::customer.form.email'),
                'class' => 'text-left searchable',
            ],
            'customer_relation' => [
                'title' => trans('plugins-customer::customer.form.customer_relation'),
                'footer' => trans('plugins-customer::customer.form.customer_relation'),
                'class' => 'text-left',
            ],
            'customer_group' => [
                'title' => trans('plugins-customer::customer.form.customer_group'),
                'footer' => trans('plugins-customer::customer.form.customer_group'),
                'class' => 'text-left',
            ],
            'customer_job' => [
                'title' => trans('plugins-customer::customer.form.jobs'),
                'footer' => trans('plugins-customer::customer.form.jobs'),
                'class' => 'text-left',
            ],
            'customer_source' => [
                'title' => trans('plugins-customer::customer.form.customer_source'),
                'footer' => trans('plugins-customer::customer.form.customer_source'),
                'class' => 'text-left',
            ],
            'value' => [
                'name' => 'customers.value',
                'title' => trans('plugins-customer::customer.form.value'),
                'footer' => trans('plugins-customer::customer.form.value'),
                'class' => 'text-left searchable',
            ],
            'dob' => [
                'name' => 'customers.dob',
                'title' => trans('plugins-customer::customer.form.dob'),
                'footer' => trans('plugins-customer::customer.form.dob'),
                'class' => 'text-left searchable',
            ],
            'address' => [
                'name' => 'customers.address',
                'title' => trans('plugins-customer::customer.form.address'),
                'footer' => trans('plugins-customer::customer.form.address'),
                'class' => 'text-left searchable',
            ],
            'ward_code' => [
                'name' => 'customers.ward_code',
                'title' => trans('plugins-customer::customer.form.ward'),
                'footer' => trans('plugins-customer::customer.form.ward'),
                'class' => 'text-left searchable',
            ],
            'district_code' => [
                'name' => 'customers.district_code',
                'title' => trans('plugins-customer::customer.form.district'),
                'footer' => trans('plugins-customer::customer.form.district'),
                'class' => 'text-left searchable',
            ],
            'province_city_code' => [
                'name' => 'customers.province_city_code',
                'title' => trans('plugins-customer::customer.form.province_city'),
                'footer' => trans('plugins-customer::customer.form.province_city'),
                'class' => 'text-left searchable',
            ],
            'website' => [
                'name' => 'customers.website',
                'title' => trans('plugins-customer::customer.form.website'),
                'footer' => trans('plugins-customer::customer.form.website'),
                'class' => 'text-left searchable',
            ],
            'facebook' => [
                'name' => 'customers.facebook',
                'title' => trans('plugins-customer::customer.form.facebook'),
                'footer' => trans('plugins-customer::customer.form.facebook'),
                'class' => 'text-left searchable',
            ],
            'note' => [
                'name' => 'customers.facebook',
                'title' => trans('plugins-customer::customer.form.note'),
                'footer' => trans('plugins-customer::customer.form.note'),
                'class' => 'text-left searchable',
            ],
            'introduce_person' => [
                'name' => 'products.introduce_person_id',
                'title' => trans('plugins-customer::customer.form.introduce_person'),
                'footer' => trans('plugins-customer::customer.form.introduce_person'),
                'class' => 'text-left searchable',
            ],
            'user_manage' => [
                'name' => 'products.user_manage_id',
                'title' => trans('plugins-customer::customer.form.user_manage'),
                'footer' => trans('plugins-customer::customer.form.user_manage'),
                'class' => 'text-left searchable',
            ],
            'created_by' => [
                'name' => 'products.created_by',
                'title' => trans('core-base::tables.created_by'),
                'footer' => trans('core-base::tables.created_by'),
                'class' => 'text-left searchable',
            ],
            'created_at' => [
                'name' => 'customers.created_at',
                'title' => trans('core-base::tables.created_at'),
                'footer' => trans('core-base::tables.created_at'),
                'width' => '100px',
                'class' => 'searchable',
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
                'link' => route('admin.customer.create'),
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
     * @return mixed|null
     */
    public function domParameter()
    {

        return "<'dt_action_wrap'" .
                    "<'dt_action_top'" .
                        "<'dt_action_custom dt_btn_wrap datable_btn_top'B<'clearfix'>>" .
                        "<'dt_action_custom dt_info_wrap dt_info_top'" .
                            "<'dt_info_custom dt_info_paging'p>" .
                            "<'dt_info_custom dt_info_length'l>" .
                            "<'dt_info_custom dt_info_entries'i>" .
                            "<'clearfix'>" .
                        ">" .
                    ">" .
                ">r" .
                "t".
                "<'dt_action_wrap'" .
                    "<'dt_action_bottom'" .
                        "<'dt_action_custom dt_btn_wrap datable_btn_bottom'B<'clearfix'>>" .
                        "<'dt_action_custom dt_info_wrap dt_info_bottom'" .
                            "<'dt_info_custom dt_info_paging'p>" .
                            "<'dt_info_custom dt_info_length'l>" .
                            "<'dt_info_custom dt_info_entries'i>" .
                            "<'clearfix'>" .
                        ">" .
                    ">" .
                ">";
    }

    /**
     * Get filename for export.
     *
     * @return string
     * @author TrinhLe
     */
    protected function filename()
    {
        return CUSTOMER_MODULE_SCREEN_NAME;
    }
}
