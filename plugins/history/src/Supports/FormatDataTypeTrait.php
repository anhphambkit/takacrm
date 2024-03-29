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
     * [$displayEmpty description]
     * @var string
     */
    protected $displayEmpty = '<empty>';

	/**
	 * [$displayAttributes description]
	 * @var [type]
	 */
	protected $displayAttributes = [
		'name' => 'Name'
	];

    /**
     * [$relationShipAttributes description]
     * @var [type]
     */
    protected $relationShipAttributes = [
        'column_name' => [
            'mapTable'  => 'table_name_here',
            'mapColumn' => 'column_name_here',
            'mapResult' => 'column_result_name_here'
        ]
    ];

    /**
     * [$numericAttributes description]
     * @var [type]
     */
    protected $numericAttributes = [
        'column_numeric'
    ];

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
        if(!is_null($value)){
            return $value ? $this->asDateTime($value) : $value;
        }
    }

    /**
     * [formatNumeric description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function formatNumeric($value)
    {
        if(!is_null($value)){
            return $value ? number_format($value, 2, ',', '.') : $value;
        }
    }

    /**
     * [formatBoolean description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function formatBoolean($attribute, $value)
    {
        if(!is_null($value)){
            $value = filter_var($value, FILTER_VALIDATE_BOOLEAN);
            $logBooleanAttributes = property_exists($this, 'logBooleanAttributes') ? $this->logBooleanAttributes : [];
            $configAttribute = $logBooleanAttributes[$attribute] ?? false;
            if($configAttribute){
                if($value) 
                    $value = $configAttribute[0] ?? $value;
                else
                    $value = $configAttribute[1] ?? $value;
            }
            return $value;
        }
    }

    /**
     * [formatReference description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function formatReference($value)
    {
        if(!is_null($value)){
            $reference = find_reference_by_id(intval($value), false);
            if($reference)
                return $reference->value;
        }
    }

    /**
     * [formatRelationShip description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function formatRelationShip($attribute, $value)
    {
        if(!is_null($value)){
            $configMapping = $this->relationShipAttributes[$attribute];
            $element = DB::table($configMapping['mapTable'])
                        ->select($configMapping['mapResult'])
                        ->where($configMapping['mapColumn'], $value)
                        ->first();
            return $element ? $element->{$configMapping['mapResult']} : null;
        }
    }

    /**
     * [formatAttributeWithType description]
     * @param  [type] $attribute [description]
     * @param  [type] $origin    [description]
     * @param  [type] $current   [description]
     * @return [type]            [description]
     */
    protected function formatAttributeWithType($attribute, $origin, $current):array
    {
        $columnType = $this->getTypeAttribute($attribute);
        if(in_array($columnType, $this->typeDateTime)){
            $origin  = $this->formatDateTime($origin);
            $current = $this->formatDateTime($current);
        }
        elseif(in_array($columnType, $this->typeBoolean)){
            $current = $this->formatBoolean($attribute, $current);
            $origin  = $this->formatBoolean($attribute, $origin);
        }
       
        return [ $origin, $current ];
    }

    /** 
     * [getTypeAttribute description]
     * @param  [type] $attribute [description]
     * @return [type]            [description]
     */
    protected function getTypeAttribute($attribute):string
    {
        return Schema::getColumnType($this->getTable(), $attribute);
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
        list($origin, $current) = $this->formatAttributeWithType($attribute, $origin, $current);

        if($this->relationShipAttributes[$attribute] ?? false){
            $origin  = $this->formatRelationShip($attribute, $origin);
            $current = $this->formatRelationShip($attribute, $current);
        }
        elseif(in_array($attribute, $this->numericAttributes)){
            $origin  = $this->formatNumeric($origin);
            $current = $this->formatNumeric($current);
        }

        $origin  = is_null($origin) ? $this->displayEmpty : $origin;
        $current = is_null($current) ? $this->displayEmpty : $current; 

    	return [ $origin, $current ];
    }

    /**
     * @param $value
     * @return array
     */
    public function formatAttributeArrayValue($value) {
        return is_array($value) ? json_encode($value) : $value;
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
        $tableName = $this->getTable();
        $displayTable = config("plugins-history.history.nameTables.{$tableName}");
        return $displayTable ?: $tableName;
    }

    /**
     * [getTargetHistory description]
     * @return [type] [description]
     */
    protected function getTargetHistory():array
    {
        $logTargetAttributes = property_exists($this, 'logTargetAttributes') ? $this->logTargetAttributes : [];
        return [
            'target_type' => $logTargetAttributes['target'] ?? null,
            'target_id' => $this->getAttribute($logTargetAttributes['primary'] ?? 'id')
        ];
    }
}