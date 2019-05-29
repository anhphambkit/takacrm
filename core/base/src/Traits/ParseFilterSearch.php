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
    protected function getFilterAjaxSearch($filters = []){
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
     * Search results
     * @return type
     */
    protected function searchResults($db, $offset = 0, $dataPageLoad = [], $count)
    {
        return [
            'data'  => $db->offset($offset)->limit($dataPageLoad['limit'])->get(),
            'count' => $count->count()
        ];
    }
}
