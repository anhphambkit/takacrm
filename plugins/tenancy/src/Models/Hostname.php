<?php

/*
 * This file is part of the hyn/multi-tenant package.
 *
 * (c) Daniël Klabbers <daniel@klabbers.email>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @see https://laravel-tenancy.com
 * @see https://github.com/hyn/multi-tenant
 */

namespace Plugins\Tenancy\Models;

use Carbon\Carbon;
use Plugins\Tenancy\Abstracts\SystemModel;
use Plugins\Tenancy\Contracts\Hostname as HostnameContract;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $fqdn
 * @property string $redirect_to
 * @property bool $force_https
 * @property Carbon $under_maintenance_since
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property int $website_id
 * @property Website $website
 */
class Hostname extends SystemModel implements HostnameContract
{
    use SoftDeletes;

    protected $dates = ['under_maintenance_since'];

    protected $fillable = [
        'fqdn',
        'redirect_to',
        'force_https',
        'under_maintenance_since',
        'website_id' ,
    ];

    public function website(): BelongsTo
    {
        return $this->belongsTo(config('tenancy.models.website'));
    }
}
