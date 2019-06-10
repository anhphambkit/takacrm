<?php
namespace Plugins\History\Contracts;

interface HistoryReferenceConfig
{
	/* Reference order status */
	const REFERENCE_HISTORY_ACTION        = 'HISTORY_ACTION';
	const REFERENCE_HISTORY_ACTION_CREATE = 'CREATE';
	const REFERENCE_HISTORY_ACTION_UPDATE = 'UPDATE';
	const REFERENCE_HISTORY_ACTION_DELETE = 'DELETE';
}