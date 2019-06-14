<?php
namespace Plugins\History\Supports;
use ReflectionClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Plugins\History\Repositories\Interfaces\HistoryRepositories;
use Plugins\History\Contracts\HistoryReferenceConfig;

trait HistoryDetectionTrait
{	
    use ValidationHistoryTrait;
    use FormatDataTypeTrait;
    use FormatJsonTrait;
    
	/**
	 * [$attributeDelete description]
	 * @var array
	 */
	protected $deleteAttributes = [
		'primaryIndex' => 'id',
	];

	/**
	 * [$createAttributes description]
	 * @var array
	 */
	protected $createAttributes = [
		'primaryIndex' => 'id',
	];

	/**
	 * [$ignoreLogAttributes description]
	 * @var [type]
	 */
	protected $ignoreLogAttributes = [
		'updated_at',
        'updated_by'
	];

	/**
	 * [bootHistoryDetection description]
	 * Register auto detection history
	 * @author TrinhLe
	 * @return [type] [description]
	 */
	protected static function bootHistoryDetectionTrait()
	{
        foreach (static::getModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->createLogHistory($event);
            });
        }
	}

	/**
	 * [createLogHistory description]
	 * @param  [type] $model [description]
	 * @author TrinhLe
	 * @return [type]        [description]
	 */
	protected function createLogHistory($eventObserver)
	{
		$actionMethod = "{$eventObserver}Observer";
		if(method_exists($this, $actionMethod)) $this->$actionMethod();
	}

	/**
     * Handle the User "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function createdObserver()
    {
        $tableName    = $this->getDisplayTable();
        $primaryValue = $this->getAttribute($this->createAttributes['primaryIndex']);
        $fieldName    = $this->getDisplayAttribute($this->createAttributes['primaryIndex']);
        $content      = "Created new record of table {$tableName} with {$fieldName} is {$primaryValue}";

        $formatted = [
            'content'        => $content,
            'value_current'  => $primaryValue,
            'field_name'     => $fieldName,
            'path_session'   => uniqid(),
            'table_name'     => $tableName,
            'attribute_name' => $this->createAttributes['primaryIndex']
        ];

        $this->saveLogAttribute($formatted, HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_CREATE);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updatedObserver()
    {
        $fieldsChanged = $this->isDirty() ? $this->getDirty() : false;
        if($fieldsChanged){
        	$fieldsChanged = $this->ignoreAttributes($fieldsChanged);
            $sessionPath = uniqid();
        	foreach ($fieldsChanged as $attribute => $newValue) {
        		# code...
                $origin                   = $this->getOriginalMutator($attribute);
                $current                  = $this->getNewValueMutator($attribute, $newValue);
                list($_origin, $_current) = $this->formatAttributeWithType($attribute, $origin, $current);

                # validation model change
                if($this->validation($_origin, $_current)){
                    $this->createOrUpdateLogHistory($attribute, $origin, $current, $sessionPath);
                }
        	}
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deletedObserver()
    {
        $tableName    = $this->getDisplayTable();
        $primaryValue = $this->getAttribute($this->deleteAttributes['primaryIndex']);
        $fieldName    = $this->getDisplayAttribute($this->deleteAttributes['primaryIndex']);
        $content      = "Deleted record of table {$tableName} with {$fieldName} is {$primaryValue}";

        $formatted = [
            'content'        => $content,
            'value_current'  => $primaryValue,
            'field_name'     => $fieldName,
            'path_session'   => uniqid(),
            'table_name'     => $tableName,
            'attribute_name' => $this->deleteAttributes['primaryIndex']
        ];
        $this->saveLogAttribute($formatted, HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_DELETE);
    }

    /**
     * [ignoreAttributes description]
     * @param  [type] $fieldsChanged [description]
     * @return [type]                [description]
     */
    public function ignoreAttributes(array $fieldsChanged):array
    {
    	if(is_array($this->ignoreLogAttributes)){
    		foreach ($this->ignoreLogAttributes as $attribute) {
    			# code...
    			if(isset($fieldsChanged[$attribute]))
    				unset($fieldsChanged[$attribute]);
    		}
    	}
    	return $fieldsChanged;
    }

    /**
     * [createOrUpdateLogHistory description]
     * @param  [type] $attribute [description]
     * @param  [type] $origin    [description]
     * @param  [type] $current   [description]
     * @return [type]            [description]
     */
    public function createOrUpdateLogHistory($attribute, $origin, $current, $sessionPath)
    {
        // if(in_array($attribute, $this->jsonAttributes)){
        //     return $this->formatJsonAttribute($attribute, $origin, $current);
        // }
        $fieldName              = $this->getDisplayAttribute($attribute);
        list($origin, $current) = $this->formatAttributeValue($attribute, $origin, $current);
        $formatted = [
            'content'       => "Updated {$fieldName} from {$origin} to {$current}",
            'value_origin'  => $origin,
            'value_current' => $current,
            'field_name'    => $fieldName,
            'path_session'  => $sessionPath,
            'table_name'    => $this->getDisplayTable(),
            'attribute_name' => $attribute
        ];
        $this->saveLogAttribute($formatted, HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_UPDATE);
    }

    /**
     * [saveLogJsonAttribute description]
     * @return [type] [description]
     */
    protected function saveLogAttribute(array $data = [], $type)
    {
        if($user = \Auth::user()){
            $formatted = array_merge([
                'user_id' => $user->id,
                'type'    => find_reference_element($type)->id
            ], $this->getTargetHistory(), $data);
            app(HistoryRepositories::class)->createOrUpdate($formatted);
        }
    }

	/**
	 * [getModelEvents description]
	 * override event Observer
	 * @author TrinhLe
	 * @return array
	 */
	protected static function getModelEvents(): array
    {
    	return static::$logEvents ?? [
    		'updated',
    		'created',
    		'deleted'
    	];
    }
}