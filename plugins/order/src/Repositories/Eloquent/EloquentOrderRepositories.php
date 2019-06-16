<?php

namespace Plugins\Order\Repositories\Eloquent;

use Core\Base\Traits\ParseFilterSearch;
use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Plugins\Order\Repositories\Interfaces\OrderRepositories;

class EloquentOrderRepositories extends RepositoriesAbstract implements OrderRepositories
{
    use ParseFilterSearch;

    /**
     * @var array conditions special.
     */
    protected $searchOptions = [
        'listAdminOrder' => [
            'id' => [
                'search_type' => 'int',
                'column' => 'orders.id',
                'operator' => '=',
            ],
            'order_date' => [
                'search_type' => 'date',
                'column' => 'orders.order_date',
                'operator' => '=',
                'date_options'=> [
                    'format_input' => "d/m/Y",
                    'format_output' => "Y-m-d",
                    'timezone' => "Asia/Ho_Chi_Minh",
                ]
            ],
            'order_code' => [
                'search_type' => 'string',
                'column' => 'orders.order_code',
                'operator' => '=',
            ],
            'customer_code' => [
                'search_type' => 'string',
                'column' => 'orders.customer_code',
                'operator' => '=',
            ],
            'customer_name' => [
                'search_type' => 'string',
                'column' => 'orders.customer_name',
                'operator' => 'ILIKE',
            ],
            'customer_address' => [
                'search_type' => 'string',
                'column' => 'orders.customer_address',
                'operator' => 'ILIKE',
            ],
            'sale_order' => [
                'search_type' => 'int',
                'column' => 'orders.sale_order',
                'operator' => '=',
            ],
            'vat_order' => [
                'search_type' => 'int',
                'column' => 'orders.vat_order',
                'operator' => '=',
            ],
            'discount_order' => [
                'search_type' => 'int',
                'column' => 'orders.discount_order',
                'operator' => '=',
            ],
            'total_order' => [
                'search_type' => 'int',
                'column' => 'orders.total_order',
                'operator' => '=',
            ],
            'created_by' => [
                'search_type' => 'int',
                'column' => 'orders.created_by',
                'operator' => '=',
            ],
            'order_status' => [
                'search_type' => 'int',
                'column' => 'orders.order_status',
                'operator' => '=',
            ],
            'payment_status' => [
                'search_type' => 'int',
                'column' => 'orders.payment_status',
                'operator' => '=',
            ],
            'created_at' => [
                'search_type' => 'date',
                'column' => 'orders.created_at',
                'operator' => '=',
                'date_options'=> [
                    'format_input' => "d/m/Y",
                    'format_output' => "Y-m-d",
                    'timezone' => "Asia/Ho_Chi_Minh",
                ]
            ],
        ]
    ];
    protected $mappingColumns = [
        0 => 'id',
        1 => 'order_date',
        2 => 'order_code',
        3 => 'customer_code',
        4 => 'customer_name',
        5 => 'customer_address',
        6 => 'sale_order',
        7 => 'vat_order',
        8 => 'discount_order',
        9 => 'total_order',
        14 => 'created_by',
        15 => 'created_at',
    ];

    protected $columnFilterTime = 'created_at';

    /**
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    public function createNewOrUpdateOrder(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param array $request
     * @return mixed
     */
    public function searchListOrder(array $request) {
        $query = $this->model->select('orders.*');
        $filters  = $this->parseFilters($query, $request, 'listAdminOrder');
        $query = $query->where($filters);
        $result = $this->getDataPageLoadDataTable($this->model, $query, $request, 'listAdminOrder');
        $this->resetModel();
        return $result;
    }
}
