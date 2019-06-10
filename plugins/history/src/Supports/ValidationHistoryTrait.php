<?php
namespace Plugins\History\Supports;
use ReflectionClass;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait ValidationHistoryTrait
{	
	/**
	 * [validation description]
	 * @param  [type] $origin  [description]
	 * @param  [type] $current [description]
	 * @return [type]          [description]
	 */
	protected function validation($origin, $current)
	{
		return $origin !== $current;
	}
}