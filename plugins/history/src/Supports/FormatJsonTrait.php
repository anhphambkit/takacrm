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
    protected function formatJsonAttribute($attribute, $origin, $current)
    {
		$_origin           = $this->swapArray($origin ?: [], $this->jsonAttributes[$attribute]['attributes_primary']);
		$_current          = $this->swapArray($current ?: [], $this->jsonAttributes[$attribute]['attributes_primary']);
		$attributesAdded   = array_diff_key($_origin, $_current);
		$attributesRemoved = array_diff_key($_current, $_origin);

		foreach ($attributesAdded as $attr) {
			# log for added attribute json
			list($value, $title, $displayName) = $this->getInformationAttributeJson($attribute);
			$content                           = "Added new {$title} with {$displayName} is {$value} ";
        	$this->saveLogAttribute($content, HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_UPDATE);
		}

		foreach ($attributesRemoved as $attr) {
			# log for removed attribute json
			list($value, $title, $displayName) = $this->getInformationAttributeJson($attribute);
			$content                           = "Removed {$title} with {$displayName} is {$value} ";
        	$this->saveLogAttribute($content, HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_UPDATE);
		}
    }

    /**
     * [getInformationAttributeJson description]
     * @param  [type] $attribute [description]
     * @return [type]            [description]
     */
    protected function getInformationAttributeJson($attribute){
    	$value       = $this->getAttribute($this->jsonAttributes[$attribute]['attribute_display']);
		$title       = $this->jsonAttributes[$attribute]['attribute_title'] ?? '';
		$displayName = $this->jsonAttributes[$attribute]['attribute_display_title'] ?? '';
		return [ $value, $title, $displayName ];
    }

    /**
     * [swapArray description]
     * @param  array  $array [description]
     * @return [type]        [description]
     */
    protected function swapArray(array $array = [], $primaryIndex):array
    {
    	$result = array();
    	foreach ($array as $key => $item) {
    		$result[$item[$primaryIndex] ?? $key] = $item;
    	}
    	return $result;
    }
}