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

	/**
	 * [$formatTime description]
	 * @var string
	 */
	protected $formatTime = 'm/d/Y';

	/**
	 * [$attributeDelete description]
	 * @var array
	 */
	protected $deleteAttributes = [
		'primaryIndex' => 'id',
		'name'         => 'name'
	];

	/**
	 * [$createAttributes description]
	 * @var array
	 */
	protected $createAttributes = [
		'primaryIndex' => 'id',
		'name'         => 'name'
	];

	/**
	 * [$ignoreLogAttributes description]
	 * @var [type]
	 */
	protected $ignoreLogAttributes = [
		'updated_at',
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
        $user = \Auth::user();
        if($user){
            $tableName = $this->getDisplayTable();
            $primaryIndex = $this->getAttribute($this->createAttributes['primaryIndex']);
            app(HistoryRepositories::class)->createOrUpdate([
                'user_id' => $user->id,
                'content' => "Created new record of table {$tableName} with id is {$primaryIndex}",
                'type'    => find_reference_element(HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_CREATE)->id
            ]);
        }
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
        	foreach ($fieldsChanged as $attribute => $newValue) {
        		# code...
                $origin                   = $this->getOriginalMutator($attribute);
                $current                  = $this->getNewValueMutator($attribute, $newValue);
                list($_origin, $_current) = $this->formatAttributeWithType($attribute, $origin, $current);

                # validation model change
                if($this->validation($_origin, $_current)){
                    $this->createOrUpdateLogHistory($attribute, $origin, $current);
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
        $user = \Auth::user();
        if($user){
            $tableName = $this->getDisplayTable();
            $primaryIndex = $this->getAttribute($this->deleteAttributes['primaryIndex']);
            app(HistoryRepositories::class)->createOrUpdate([
                'user_id' => $user->id,
                'content' => "Deleted record of table {$tableName} with id is {$primaryIndex}",
                'type'    => find_reference_element(HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_DELETE)->id
            ]);
        }
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
    public function createOrUpdateLogHistory($attribute, $origin, $current)
    {
        $fieldName = $this->getDisplayAttribute($attribute);
        $user = \Auth::user();
        if($user){
            app(HistoryRepositories::class)->createOrUpdate([
                'user_id' => $user->id,
                'content' => "Updated {$fieldName} from {$origin} to {$current}",
                'type'    => find_reference_element(HistoryReferenceConfig::REFERENCE_HISTORY_ACTION_UPDATE)->id
            ]);
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