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

namespace Plugins\Tenancy;

use Plugins\Tenancy\Contracts\CurrentHostname;
use Plugins\Tenancy\Contracts\Hostname;
use Plugins\Tenancy\Contracts\Tenant;
use Plugins\Tenancy\Contracts\Website;
use Plugins\Tenancy\Database\Connection;
use Plugins\Tenancy\Events;
use Plugins\Tenancy\Jobs\HostnameIdentification;
use Plugins\Tenancy\Traits\DispatchesEvents;
use Plugins\Tenancy\Traits\DispatchesJobs;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Traits\Macroable;

class Environment
{
    use DispatchesJobs, DispatchesEvents, Macroable;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @var bool
     */
    protected $installed;

    public function __construct(Application $app)
    {
        $this->app = $app;

        $this->defaults();

        if ($this->installed() &&
            (! $app->runningInConsole() || $app->runningUnitTests()) &&
            config('tenancy.hostname.auto-identification')) {
            $this->identifyHostname();
            // Identifies the current hostname, sets the binding using the native resolving strategy.
            $app->make(CurrentHostname::class);
        }
    }

    public function installed(): bool
    {
        $isInstalled = function (): bool {
            /** @var \Illuminate\Database\Connection $connection */
            $connection = $this->app->make(Connection::class)->system();
            /** @var string $table */
            $table = $this->app->make(Website::class)->getTable();

            try {
                $tableExists = $connection->getSchemaBuilder()->hasTable($table);
            } finally {
                return $tableExists ?? false;
            }
        };

        return $this->installed ?? $this->installed = $isInstalled();
    }

    public function identifyHostname()
    {
        $this->app->singleton(CurrentHostname::class, function () {
            /** @var Hostname $hostname */
            $hostname = $this->dispatch(new HostnameIdentification());

            $this->tenant(optional($hostname)->website);

            return $hostname;
        });
    }

    /**
     * Get or set the current hostname.
     *
     * @param Hostname|null $hostname
     * @return Hostname|null
     */
    public function hostname(Hostname $hostname = null): ?Hostname
    {
        if ($hostname !== null) {
            $this->app->instance(CurrentHostname::class, $hostname);

            $this->emitEvent(new Events\Hostnames\Switched($hostname));

            return $hostname;
        }

        return $this->app->make(CurrentHostname::class);
    }

    public function website(): ?Website
    {
        $hostname = $this->hostname();

        return $hostname ? $hostname->website : null;
    }

    /**
     * Get or set current tenant.
     *
     * @param Website|null $website
     * @return Tenant|null
     */
    public function tenant(Website $website = null): ?Website
    {
        if ($website !== null) {
            $this->app->instance(Tenant::class, $website);

            $this->emitEvent(new Events\Websites\Switched($website));

            return $website;
        }

        return $this->app->make(Tenant::class);
    }

    protected function defaults()
    {
        $empty = function () {
            return null;
        };

        $this->app->singleton(Tenant::class, $empty);
        $this->app->singleton(CurrentHostname::class, $empty);
    }
}
