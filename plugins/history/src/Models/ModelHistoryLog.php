<?php

namespace Plugins\History\Models;
use Plugins\History\Supports\HistoryDetectionTrait;
use Illuminate\Database\Eloquent\Model;

abstract class ModelHistoryLog extends Model
{
	use HistoryDetectionTrait;
}