<?php
use Illuminate\Support\Facades\DB;

if (function_exists('find_reference_element') === false) {
    /**
     * [find_reference_element description]
     * @param  [type] $referenceValue [description]
     * @param  [type] $referenceType  [description]
     * @return Illuminate\Support\Collection
     */
    function find_reference_element($referenceValue, ?string $referenceType = null)
    {
        $element = DB::table('references')
                        ->where(function($query) use ($referenceValue, $referenceType){
                            $query->where('value', $referenceValue);
                            if($referenceType) $query->where('type', $referenceType);
                        })->first();

        return $element ?? abort(403, 'reference not found, please make sure seeder running');
    }
}

if (function_exists('find_reference_by_id') === false) {
    /**
     * [find_reference_element description]
     * @param  [type] $referenceValue [description]
     * @param  [type] $referenceType  [description]
     * @return Illuminate\Support\Collection
     */
    function find_reference_by_id(int $id, bool $isException = true)
    {
        $element =  DB::table('references')->where('id', $id)->first();
        if($isException)
            return $element ?? abort(403, 'reference not found, please make sure seeder running');
        return $element;
    }
}