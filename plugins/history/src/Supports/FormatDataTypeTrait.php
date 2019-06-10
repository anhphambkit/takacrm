<?php
namespace Plugins\History\Supports;
use ReflectionClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait FormatDataTypeTrait
{
	/**
	 * [$displayAttributes description]
	 * @var [type]
	 */
	protected $displayAttributes = [
		'name' => 'Name'
	];

	/**
	 * [$referenceAttributes description]
	 * @var [type]
	 */
	protected $referenceAttributes = [];

	/**
	 * [$typeDateTime description]
	 * @var [type]
	 */
	protected $typeDateTime = ['datetime','date'];

	/**
	 * [$typeBoolean description]
	 * @var array
	 */
	protected $typeBoolean = ['boolean'];

	/**
     * [formatDateTimeType description]
     * @param  [type] $value      [description]
     * @param  string $formatTime [description]
     * @return [type]             [description]
     */
    protected function formatDateTime($value)
    {
    	return $value ? $this->asDateTime($value) : $value;
    }

    /**
     * [formatNumeric description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function formatNumeric($value)
    {
    	return $value ? $this->asDateTime($value) : $value;
    }

    /**
     * [formatBoolean description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function formatBoolean($value)
    {
    	return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * [formatReference description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function formatReference($value)
    {
    	$reference = find_reference_by_id(intval($value), false);
    	if($reference)
    		return $reference->value;
    }

    /**
     * [formatAttributeValue description]
     * @param  [type] $attribute [description]
     * @param  [type] $origin    [description]
     * @param  [type] $current   [description]
     * @return [type]            [description]
     */
    public function formatAttributeValue($attribute, $origin, $current):array
    {
    	$columnType = Schema::getColumnType($this->getTable(), $attribute);
    	if(in_array($columnType, $this->typeDateTime)){
            $origin = $this->formatDateTime($origin);
            $current = $this->formatDateTime($current);
    	}
    	elseif(in_array($columnType, $this->typeBoolean)){
    		$current = $this->formatBoolean($current);
    		$origin = $this->formatBoolean($origin);
    	}
    	elseif(in_array($attribute, $this->referenceAttributes)){
    		$current = $this->formatReference($current);
            $origin = $this->formatReference($origin);
    	}

    	return [ $origin, $current ];
    }

    /**
     * [getOriginalMutator description]
     * @param  [type] $attr [description]
     * @return [type]       [description]
     */
    protected function getOriginalMutator($attr)
    {
        $origin = $this->getOriginal($attr);
    	return ( $this->hasGetMutator($attr) )
    		? $this->mutateAttribute($attr, $origin)
    		: $origin;
    }

    /**
     * [getNewValueMutator description]
     * @param  [type] $attr      [description]
     * @param  [type] $newValue [description]
     * @return [type]            [description]
     */
    protected function getNewValueMutator($attr, $newValue)
    {
    	return ( $this->hasGetMutator($attr) )
    		? $this->mutateAttribute($attr, $newValue)
    		: $newValue;
    }

    /**
     * [getDisplayAttribute description]
     * @param  [type] $attr [description]
     * @return [type]       [description]
     */
    protected function getDisplayAttribute($attr)
    {
    	return array_get($this->displayAttributes, $attr, $attr);
    }

    /**	
     * [getDisplayTable description]
     * @return [type] [description]
     */
    protected function getDisplayTable()
    {
    	return $this->displayTable ?? $this->getTable();
    }
}