<?php

namespace Core\Slug\Models;

use Eloquent;

/**
 * Core\Slug\Models\Slug
 *
 * @mixin \Eloquent
 */
class Slug extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'slugs';

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'reference',
        'reference_id',
        'prefix',
    ];
}
