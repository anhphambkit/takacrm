<?php

namespace Plugins\Tenancy\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Tenancy\Models\Tenancy
 *
 * @mixin \Eloquent
 */
class Tenancy extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tenancy';

    protected $fillable = ['name'];
}
