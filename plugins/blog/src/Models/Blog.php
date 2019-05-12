<?php

namespace Plugins\Blog\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Blog\Models\Blog
 *
 * @mixin \Eloquent
 */
class Blog extends Eloquent
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blog';

    protected $fillable = ['name'];
}
