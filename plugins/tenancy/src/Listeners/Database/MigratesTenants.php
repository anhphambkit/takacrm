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

namespace Plugins\Tenancy\Listeners\Database;

use Plugins\Tenancy\Abstracts\WebsiteEvent;
use Plugins\Tenancy\Database\Connection;
use Plugins\Tenancy\Traits\DispatchesEvents;
use Illuminate\Contracts\Events\Dispatcher;
use Plugins\Tenancy\Events;

class MigratesTenants
{
    use DispatchesEvents;
    /**
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Events\Websites\Created::class, [$this, 'migrate']);
    }

    /**
     * @param WebsiteEvent $event
     * @return bool
     */
    public function migrate(WebsiteEvent $event): bool
    {
        $paths = $this->getMigrationPaths();

        foreach ($paths as $path) {
            if ($path && realpath($path) && $this->connection->migrate($event->website, $path)) {
                $this->emitEvent(new Events\Websites\Migrated($event->website));
            }
        }

        return true;
    }

    protected function getMigrationPaths()
    {
        $paths = [];

        if (($systemPath = config('tenancy.db.system-migrations-path')) && !empty($systemPath))
            array_push($paths, $systemPath);

        if (($path = config('tenancy.db.tenant-migrations-path')) && !empty($path)) {
            array_push($paths, $path);
        }

        return $paths;
    }
}
