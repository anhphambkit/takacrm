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
use Plugins\Tenancy\Contracts\Website as WebsiteContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $uuid
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property string $managed_by_database_connection
 * @property Hostname[] $hostnames
 */
class Website extends SystemModel implements WebsiteContract
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'host_name',
        'host_ip',
        'host_port',
        'managed_by_database_connection'
    ];

    public function hostnames(): HasMany
    {
        return $this->hasMany(config('tenancy.models.hostname'));
    }
}
