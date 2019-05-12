<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-30
 * Time: 09:11
 */

namespace Core\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'references';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'value',
        'slug',
        'type',
        'order',
        'is_default',
        'publish',
        'group'
    ];

    public $timestamps = true;
}