<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-20
 * Time: 08:28
 */

namespace Plugins\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LookBookTag extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'look_book_tags';

    protected $fillable = [
        'look_book_id',
        'product_id',
        'product_category_id',
        'left',
        'top',
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