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

namespace Plugins\Tenancy\Contracts\Webserver;

use Plugins\Tenancy\Database\Connection;
use Plugins\Tenancy\Events\Websites\Created;
use Plugins\Tenancy\Events\Websites\Deleted;
use Plugins\Tenancy\Events\Websites\Updated;

interface DatabaseGenerator
{
    public function created(Created $event, array $config, Connection $connection): bool;
    public function updated(Updated $event, array $config, Connection $connection): bool;
    public function deleted(Deleted $event, array $config, Connection $connection): bool;
}
