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

namespace Plugins\Tenancy\Traits;

use Plugins\Tenancy\Abstracts\AbstractEvent;
use Illuminate\Contracts\Events\Dispatcher;

trait DispatchesEvents
{
    /**
     * @param AbstractEvent $event
     * @param array $payload
     * @return array|null
     */
    public function emitEvent(AbstractEvent $event, array $payload = [])
    {
        return app(Dispatcher::class)->fire($event, $payload);
    }
}
