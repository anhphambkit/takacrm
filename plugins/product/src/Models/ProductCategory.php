<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-04-13
 * Time: 05:13
 */

namespace Plugins\Product\Models;

use Core\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Plugins\History\Models\ModelHistoryLog;

class ProductCategory extends ModelHistoryLog
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'order',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author AnhPham
     */
    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    ################### LOGGER ###########################
    /**
     * [$displayAttributes description]
     * @var [type]
     */
    protected $displayAttributes = [
        'name' => 'Category Name'
    ];

    /**
     * [$relationShipAttributes description]
     * @var [type]
     */
    protected $relationShipAttributes = [
        'parent_id' => [
            'mapTable'  => 'product_categories',
            'mapColumn' => 'id',
            'mapResult' => 'name'
        ]
    ];

    /**
     * [$relationShipAttributes description]
     * @var [type]
     */
    protected $logTargetAttributes = [
        'target' => HISTORY_MODULE_PRODUCT_CATEGORY,
        'primary' => 'id'
    ];
}