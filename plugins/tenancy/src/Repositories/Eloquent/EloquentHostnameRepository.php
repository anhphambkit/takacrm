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

namespace Plugins\Tenancy\Repositories\Eloquent;

use Core\Master\Repositories\Eloquent\RepositoriesAbstract;
use Plugins\Tenancy\Repositories\Interfaces\HostnameRepository as Contract;
use Plugins\Tenancy\Events\Hostnames as Events;
use Plugins\Tenancy\Contracts\Hostname;
use Plugins\Tenancy\Contracts\Website;
use Plugins\Tenancy\Traits\DispatchesEvents;
use Plugins\Tenancy\Validators\HostnameValidator;
use Illuminate\Database\Eloquent\Builder;

class EloquentHostnameRepository extends RepositoriesAbstract implements Contract
{
    use DispatchesEvents;

    /**
     * @param string $hostname
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|Hostname|null
     */
    public function findByHostname(string $hostname)
    {
        return $this->model->newQuery()->where('fqdn', $hostname)->first();
    }

    /**
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|Hostname|null
     */
    public function getDefault()
    {
        if (config('tenancy.hostname.default')) {
            return $this->model->newQuery()->where('fqdn', config('tenancy.hostname.default'))->first();
        }

        return null;
    }

    /**
     * @param Hostname $hostname
     * @return Hostname
     */
    public function createFromCollection(Hostname &$hostname): Hostname
    {
        if ($hostname->exists) {
            return $this->updateFromCollection($hostname);
        }

        $this->emitEvent(
            new Events\Creating($hostname)
        );

        app()->make(HostnameValidator::class)->save($hostname);

        $hostname->save();

        $this->emitEvent(
            new Events\Created($hostname)
        );

        return $hostname;
    }

    /**
     * @param Hostname $hostname
     * @return Hostname
     */
    public function updateFromCollection(Hostname &$hostname): Hostname
    {
        if (!$hostname->exists) {
            return $this->createFromCollection($hostname);
        }

        $this->emitEvent(
            new Events\Updating($hostname)
        );

        app()->make(HostnameValidator::class)->save($hostname);

        $dirty = collect(array_keys($hostname->getDirty()))->mapWithKeys(function ($value, $key) use ($hostname) {
            return [ $value => $hostname->getOriginal($value) ];
        });

        $hostname->save();

        $this->emitEvent(
            new Events\Updated($hostname, $dirty->toArray())
        );

        return $hostname;
    }

    /**
     * @param Hostname $hostname
     * @param bool $hard
     * @return Hostname
     */
    public function deleteFromCollection(Hostname &$hostname, $hard = false): Hostname
    {
        $this->emitEvent(
            new Events\Deleting($hostname)
        );

        app()->make(HostnameValidator::class)->delete($hostname);

        if ($hard) {
            $hostname->forceDelete();
        } else {
            $hostname->delete();
        }

        $this->emitEvent(
            new Events\Deleted($hostname)
        );

        return $hostname;
    }

    /**
     * @param Hostname $hostname
     * @param Website $website
     * @return Hostname
     */
    public function attach(Hostname &$hostname, Website &$website): Hostname
    {
        $website->hostnames()->save($hostname);

        // Required to refresh relationship objects.
        $website->load('hostnames');

        $this->emitEvent(
            new Events\Attached($hostname, $website)
        );

        return $hostname;
    }

    /**
     * @param Hostname $hostname
     * @return Hostname
     */
    public function detach(Hostname &$hostname): Hostname
    {
        $hostname->website()->dissociate();

        $this->emitEvent(
            new Events\Detached($hostname)
        );

        return $hostname;
    }

    /**
     * @warn Only use for querying.
     * @return Builder
     */
    public function query(): Builder
    {
        return $this->model->newQuery();
    }
}
