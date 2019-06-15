<?php
namespace Plugins\History\Supports;

use ReflectionClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Plugins\History\Repositories\Interfaces\HistoryRepositories;
use Plugins\History\Contracts\HistoryReferenceConfig;

trait FormatJsonTrait
{
	/**
     * [$relationShipAttributes description]
     * @var [type]
     */
    protected $jsonAttributes = [
        'column_name' => [
			'attribute_title'         => 'Product',
			'attributes_primary'      => 'id',
			'attribute_display'       => 'name',
			'attribute_display_title' => 'Name',
			'attributes_log'          => ['price', 'name', 'qty']
        ],
    ];

    /**
     * [formatBoolean description]
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function formatJsonAttribute($attribute, $origin, $current, $sessionPath)
    {
		$_origin           = $this->formatJsonArray($origin ?: []);
		$_current          = $this->formatJsonArray($current ?: []);
		$attributesAdded   = array_diff($_origin, $_current);
		$attributesRemoved = array_diff($_current, $_origin);

		foreach ($attributesAdded as $attr) {
			# log for added attribute json
			$formatted = $this->getInformationAttributeJson($attribute, $attr, $sessionPath);
        	$this->saveLogAttribute($formatted, HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_CREATE);
		}

		foreach ($attributesRemoved as $attr) {
			# log for removed attribute json
			$formatted = $this->getInformationAttributeJson($attribute, $attr, $sessionPath, false);
            $this->saveLogAttribute($formatted, HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_DELETE);
		}
    }

    /**
     * [getInformationAttributeJson description]
     * @param  [type] $attribute [description]
     * @return [type]            [description]
     */
    protected function getInformationAttributeJson($attribute, $value, $sessionPath, $isCreated = true)
    {
        $fieldName = $this->getDisplayAttribute($attribute);
        $tableName = $this->getDisplayTable();
        if($isCreated)
            $content = "Added new {$fieldName} with value is {$value} ";
        else
            $content = "Deleted record {$fieldName} with value is {$value} ";

        return $formatted = [
            'content'        => $content,
            'value_current'  => $value,
            'field_name'     => $fieldName,
            'path_session'   => $sessionPath,
            'table_name'     => $tableName,
            'attribute_name' => $attribute
        ];
    }

    /**
     * [swapArray description]
     * @param  array  $array [description]
     * @return [type]        [description]
     */
    protected function formatJsonArray(array $items = []):array
    {
    	$result = array();
    	foreach($items as $item){
            $result[] = $item;
        }
        return $result;
    }
}