<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-27
 * Time: 10:55
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;

class LookBookBusinessTypeSpaceRelation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'look_book_business_type_space_relation';

    protected $fillable = [
        'business_type_id',
        'space_id',
        'look_book_id',
        'apply_all',
        'created_by',
        'updated_by',
    ];

    /**
     * Get the look book that owns the look book tag.
     */
    public function lookBook()
    {
        return $this->belongsTo(LookBook::class);
    }
}