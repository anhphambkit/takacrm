<?php

namespace Core\Setting\Models;

use Eloquent;

/**
 * Core\Setting\Models\SettingModel
 *
 * @mixin \Eloquent
 */
class Setting extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    /**
     * @var array
     */
    protected $fillable = [];
}
