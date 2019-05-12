<?php

namespace Plugins\Newsletter\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Newsletter\Models\Newsletter
 *
 * @mixin \Eloquent
 */
class Newsletter extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'newsletter';

    protected $fillable = ['name', 'email', 'status'];
}
