<?php

namespace Plugins\Customer\Repositories\Eloquent;

use Core\Base\Traits\ParseFilterSearch;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Core\Setting\Contracts\ReferenceConfig;
use Plugins\Customer\Repositories\Interfaces\CustomerRepositories;

class EloquentCustomerRepositories extends RepositoriesAbstract implements CustomerRepositories
{
    use ParseFilterSearch;

    /**
     * @var array conditions special.
     */
    protected $searchOptions = [
        'listAdminConsumer' => [
            'full_name' => [
                'search_type' => 'string',
                'column' => 'customers.full_name',
                'operator' => 'ILIKE',
            ],
            'status' => [
                'search_type' => 'bool',
                'column' => 'customers.status',
                'operator' => '=',
            ],
            'customer_code' => [
                'search_type' => 'string',
                'column' => 'customers.customer_code',
                'operator' => '=',
            ],
            'phone' => [
                'search_type' => 'string',
                'column' => 'customers.phone',
                'operator' => '=',
            ],
            'customer_relationship_id' => [
                'search_type' => 'int',
                'column' => 'customers.customer_relationship_id',
                'operator' => '=',
            ],
            'gender' => [
                'search_type' => 'string',
                'column' => 'customers.gender',
                'operator' => '=',
            ],
            'email' => [
                'search_type' => 'string',
                'column' => 'customers.email',
                'operator' => '=',
            ],
            'dob' => [
                'search_type' => 'date',
                'column' => 'customers.dob',
                'operator' => '=',
                'date_options'=> [
                    'format_input' => "d/m/Y",
                    'format_output' => "Y-m-d",
                    'timezone' => "Asia/Ho_Chi_Minh",
                ]
            ],
            'fax' => [
                'search_type' => 'string',
                'column' => 'customers.fax',
                'operator' => '=',
            ],
            'website' => [
                'search_type' => 'string',
                'column' => 'customers.website',
                'operator' => '=',
            ],
            'facebook' => [
                'search_type' => 'string',
                'column' => 'customers.facebook',
                'operator' => '=',
            ],
            'address' => [
                'search_type' => 'string',
                'column' => 'customers.address',
                'operator' => '=',
            ],
            'province_city_code' => [
                'search_type' => 'int',
                'column' => 'customers.province_city_code',
                'operator' => '=',
            ],
            'district_code' => [
                'search_type' => 'int',
                'column' => 'customers.district_code',
                'operator' => '=',
            ],
            'ward_code' => [
                'search_type' => 'int',
                'column' => 'customers.ward_code',
                'operator' => '=',
            ],
            'type_reference_data' => [
                'search_type' => 'string',
                'column' => 'customers.type_reference_data',
                'operator' => '=',
            ],
            'introduce_person_id' => [
                'search_type' => 'int',
                'column' => 'customers.introduce_person_id',
                'operator' => '=',
            ],
            'customer_group_id' => [
                'search_type' => 'int',
                'column' => 'customer_group_relation.customer_group_id',
                'operator' => '=',
                'join_table' => [
                    'table' => 'customer_group_relation',
                    'join_condition_left' => 'customers.id',
                    'join_condition_right' => 'customer_group_relation.customer_id',
                    'type_join' => 'left',
                ]
            ],
            'customer_source_id' => [
                'search_type' => 'int',
                'column' => 'customer_source_relation.customer_source_id',
                'operator' => '=',
                'join_table' => [
                    'table' => 'customer_source_relation',
                    'join_condition_left' => 'customers.id',
                    'join_condition_right' => 'customer_source_relation.customer_id',
                    'type_join' => 'left',
                ]
            ],
            'user_manage_id' => [
                'search_type' => 'int',
                'column' => 'customers.user_manage_id',
                'operator' => '=',
            ],
            'created_by' => [
                'search_type' => 'int',
                'column' => 'customers.created_by',
                'operator' => '=',
            ],
            'customer_job_id' => [
                'search_type' => 'int',
                'column' => 'customer_job_relation.customer_job_id',
                'operator' => '=',
                'join_table' => [
                    'table' => 'customer_job_relation',
                    'join_condition_left' => 'customers.id',
                    'join_condition_right' => 'customer_job_relation.customer_id',
                    'type_join' => 'left',
                ]
            ]
        ]
    ];

    /**
     * @return mixed
     */
    public function getAllCustomers()
    {
        $data = $this->model
            ->select('id', 'full_name as text', 'avatar')
            ->orderBy('full_name', 'desc')
            ->get();
        $this->resetModel();
        return $data;
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function searchListCustomer(array $request) {
        $query = $this->model->select('customers.*');
        $filters  = $this->parseFilters($query, $request, 'listAdminConsumer');
        $data = $query->where($filters)->get();
        $this->resetModel();
        return $data;
    }

    /**
     * @param string $type
     * @param int $id
     * @return mixed
     */
    public function getListCustomerIntroducedByTypeAndId(string $type, int $id) {
        $result = collect([]);
        switch ($type) {
            case ReferenceConfig::REFERENCE_CUSTOMER_DATA:
                $result = $this->model->select('*')
                    ->where('type_reference_data', $type)
                    ->where('introduce_person_id', $id)
                    ->get();
                break;
            case ReferenceConfig::REFERENCE_USER_DATA:
                break;
        }
        return $result;
    }
}
