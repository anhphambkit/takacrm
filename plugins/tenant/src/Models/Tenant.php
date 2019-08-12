<?php

namespace Plugins\Tenant\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Plugins\Tenant\Models\Tenant
 *
 * @mixin \Eloquent
 */
class Tenant extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tenants';

    protected $dates = ['under_maintenance_since'];

    protected $fillable = [
        'host_name',
        'db_name',
        'db_ip',
        'db_port',
        'managed_by_database_connection',
        'fqdn',
        'redirect_to',
        'force_https',
        'under_maintenance_since',
    ];
}
