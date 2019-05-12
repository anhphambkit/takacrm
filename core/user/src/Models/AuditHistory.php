<?php

namespace Core\User\Models;

use Core\User\Models\User;
use Eloquent;

class AuditHistory extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'audit_history';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * @author TrinhLe
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
