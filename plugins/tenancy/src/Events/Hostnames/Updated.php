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

namespace Plugins\Tenancy\Events\Hostnames;

use Plugins\Tenancy\Abstracts\HostnameEvent;
use Plugins\Tenancy\Contracts\Hostname;

class Updated extends HostnameEvent
{
    /**
     * @var array
     */
    public $dirty;

    public function __construct(Hostname $hostname = null, array $dirty = [])
    {
        parent::__construct($hostname);

        $this->dirty = $dirty;
    }
}
