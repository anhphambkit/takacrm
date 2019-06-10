<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-05-04
 * Time: 13:53
 */

namespace Core\Base\Traits;

trait ParseFilterSearch
{
    /**
     * @var array conditions special.
     */
    protected $signalFilters = [
        'LIKE',
        'ILIKE'
    ];

    /**
     * @param array $filters
     * @return array
     */
    protected function getDataPageLoad($filters = []){
        $columnsTable = config('agoyu.column-sort-table');
        $sortOrder = null;
        $orderBy = null;
        if (isset($filters['ascending']) && !empty($filters['ascending'])) {
            $sortOrder = ($filters['ascending'] == 0 ? 'desc' : 'asc');
        }
        if (isset($filters['orderBy']) && !empty($filters['orderBy'])) {
            $orderBy = (isset($columnsTable[$filters['orderBy']]) && !empty($columnsTable[$filters['orderBy']])) ? $columnsTable[$filters['orderBy']] : null;
        }
        return [
            'page'  => empty($filters['page']) ? null : intval($filters['page']),
            'limit' => empty($filters['limit']) ? null : intval($filters['limit']),
            'orderBy' => $orderBy,
            'sortOrder' => $sortOrder
        ];
    }

    /**
     * @param array $filters
     * @return array
     */
    protected function getFilterAjaxSearch(array $filters = []){
        $page = empty($filters['page']) ? 0 : intval($filters['page']);
        $limit = empty($filters['limit']) ? 0 : intval($filters['limit']);
        $offset = ($page<2) ? 0 : ($page-1)*$limit;
        $searchKey = empty($filters['searchKey']) ? null : trim($filters['searchKey']);
        return [
            'page'  => $page,
            'offset'  => $offset,
            'limit'  => $limit,
            'search_key' => $searchKey,
        ];
    }

    /**
     * @param $currentModel
     * @param $query
     * @param array $request
     * @param string $key
     * @return array
     */
    public function getDataPageLoadDataTable($currentModel, $query, array $request = [], string $key = '') {
        $mappingColumns =  property_exists($this, 'mappingColumns') ? $this->mappingColumns : [];
        $searchOptions =  property_exists($this, 'searchOptions') ? $this->searchOptions : [];

        $draw = (int)$request['draw'];
        $start = (int)$request['start'];
        $limit = (int)$request['length'];
        $searchValue = trim($request['search']['value']);
        $searchRegex = $request['search']['regex'];

        // Get array columns order able and search able
        $requestColumns = $request['columns'];
        $orderAbleColumns = [];
        $searchColumns = [];
        $searchAbleColumns = [];
        foreach ($requestColumns as $keyColumn => $requestColumn) {
            if (($requestColumn['orderable'] === "true" || $requestColumn['orderable'] === "1") && array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns) !== false)
                array_push($orderAbleColumns, array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns));

            if (($requestColumn['searchable'] === "true" || $requestColumn['searchable'] === "1") && array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns) !== false) {
                if (!empty($requestColumn['search']['value']))
                    array_push($searchColumns, [
                        'id' => array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns),
                        'value' => $requestColumn['search']['value'],
                        'search_regex' => $requestColumn['search']['regex'],
                    ]);
                array_push($searchAbleColumns, array_search((!empty($requestColumn['name']) ? $requestColumn['name'] : $requestColumn['data']), $mappingColumns));
            }
        }

        // Get array order columns:
        $orders = [];
        $requestOrders = $request['order'];
        foreach ($requestOrders as $keyRequestOrder => $requestOrder) {
            if (in_array((int)$requestOrder['column'], $orderAbleColumns))
                $orders[$requestOrder['column']] = $requestOrder['dir'];
        }

        $whereConditions = $orWhereConditions = [];
        // Get array where conditions and orWhere conditions:
        if (!empty($searchValue)) {
            $isWhereSearch = true;
            foreach ($searchAbleColumns as $keySearchAbleColumn => $searchAbleColumn) {
                if (isset($mappingColumns[$searchAbleColumn]) && isset($searchOptions["$key"][$mappingColumns[$searchAbleColumn]])) {
                    $columnSearch = $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['column'];
                    $typeSearch = $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['search_type'];
                    $operatorSearch = $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['operator'];
                    $condition = [];
                    switch ($typeSearch) {
                        case 'string':
                            if (!empty($searchValue)) {
                                $valueSearch = $searchValue;
                                if ($operatorSearch === "ILIKE" || $operatorSearch === "LIKE")
                                    $valueSearch = "%{$searchValue}%";
                                $condition = [
                                    $columnSearch, $operatorSearch, $valueSearch
                                ];
                            }
                            break;
                        case 'int':
                            $condition = [
                                $columnSearch, $operatorSearch, (int)$searchValue
                            ];
                            break;
                        case 'bool':
                            $condition = [
                                $columnSearch, $operatorSearch, (bool)$searchValue
                            ];
                            break;
                        case 'date':
                            $searchValue = format_date_time(trim($searchValue), $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['date_options']['timezone'], $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['date_options']['format_input'], $searchOptions["$key"][$mappingColumns[$searchAbleColumn]]['date_options']['format_output']);
                            $condition = [
                                $columnSearch, $operatorSearch, $searchValue
                            ];
                            break;
                    }
                    if (!empty($condition)) {
                        if ($isWhereSearch)
                            array_push($whereConditions, $condition);
                        else
                            array_push($orWhereConditions, $condition);
                    }
                    $isWhereSearch = false;
                }
            }
        }

        // Add where search
        if (!empty($whereConditions))
            $query = $query->where($whereConditions);

        // Add orWhere search:
        foreach ($orWhereConditions as $orWhereCondition) {
            $query = $query->orWhere([$orWhereCondition]);
        }

        // Parse order query:
        foreach ($orders as $keyOrder => $order) {
            $columnOrder = $searchOptions["$key"][$mappingColumns[$keyOrder]]['column'];
            $query = $query->orderBy($columnOrder, $order);
        }

        $queryCount = clone $query;
        $data = $query->offset($start)->limit($limit)->get();
        $totalFiltered = $queryCount->count();
        $totalData = $currentModel->count();
        return [
            "draw"            => $draw,
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        ];
    }

    /**
     * @param $query
     * @param array $filters
     * @param string $key
     * @return array
     */
    protected function parseFilters(&$query, $filters = [], $key = '')
    {
        $searchOptions =  property_exists($this, 'searchOptions') ? $this->searchOptions : [];

        $searchFilters = [];
        if(!empty($filters)){
            if(!empty($searchOptions["$key"]))
            {
                $searchConditions = $searchOptions["$key"];
                foreach($searchConditions as $keyFilter => $searchCondition)
                {
                    if(isset($filters["$keyFilter"]))
                    {
                        $condition = [];
                        switch ($searchCondition['search_type']) {
                            case 'string':
                                $valueRequestFormat = trim($filters["$keyFilter"]);
                                if (!empty($valueRequestFormat)) {
                                    $valueSearch = $valueRequestFormat;
                                    if ($searchCondition['operator'] === "ILIKE" || $searchCondition['operator'] === "LIKE")
                                        $valueSearch = "%{$valueRequestFormat}%";
                                    $condition = [
                                        $searchCondition['column'], $searchCondition['operator'], $valueSearch
                                    ];
                                }
                                break;
                            case 'int':
                                $condition = [
                                    $searchCondition['column'], $searchCondition['operator'], (int)$filters["$keyFilter"]
                                ];
                                break;
                            case 'bool':
                                $condition = [
                                    $searchCondition['column'], $searchCondition['operator'], (bool)$filters["$keyFilter"]
                                ];
                                break;
                            case 'date':
                                $valueRequestFormat = format_date_time(trim($filters["$keyFilter"]), $searchCondition['date_options']['timezone'], $searchCondition['date_options']['format_input'], $searchCondition['date_options']['format_output']);
                                $condition = [
                                    $searchCondition['column'], $searchCondition['operator'], $valueRequestFormat
                                ];
                                break;
                        }
                        if (!empty($condition))
                            array_push($searchFilters, $condition);

                        if (!empty($searchCondition['join_table'])) {
                            switch ($searchCondition['join_table']['type_join']) {
                                case 'left':
                                    $query = $query->leftJoin($searchCondition['join_table']['table'], $searchCondition['join_table']['join_condition_left'], '=', $searchCondition['join_table']['join_condition_right']);
                                    break;
                                case 'right':
                                    $query = $query->rightJoin($searchCondition['join_table']['table'], $searchCondition['join_table']['join_condition_left'], '=', $searchCondition['join_table']['join_condition_right']);
                                    break;
                            }
                        }
                    }
                }
            }
        }

        try{
            $function = $key. 'AfterParseSearchFilters';
            !method_exists($this,$function) ? : $this->$function($filters, $searchFilters);
        }catch(\Exception $ex)
        {
            //Nothing
        }

        return $searchFilters;
    }

    /**
     * Get results after search
     * @param type|array $filters
     * @param type|array $dataPageLoad
     * @param type $db
     * @return mixed
     */
    protected function getSearch($filters = [], $dataPageLoad = [], $db)
    {
        if(!empty($filters))
            $db->where($filters);

        if ($dataPageLoad['orderBy'] !== null) {
            $db->orderBy($dataPageLoad['orderBy'], $dataPageLoad['sortOrder']);
        }

        if(empty($dataPageLoad['page']))
            return $db->get();

        $count = clone $db;
        $offset = ($dataPageLoad['page']<2) ? 0 : ($dataPageLoad['page']-1)*$dataPageLoad['limit'];

        return $this->searchResults($db, $offset, $dataPageLoad, $count);
    }

    /**
     * @param $db
     * @param int $offset
     * @param array $dataPageLoad
     * @param $count
     * @return array
     */
    protected function searchResults($db, $offset = 0, $dataPageLoad = [], $count)
    {
        return [
            'data'  => $db->offset($offset)->limit($dataPageLoad['limit'])->get(),
            'count' => $count->count()
        ];
    }
}
