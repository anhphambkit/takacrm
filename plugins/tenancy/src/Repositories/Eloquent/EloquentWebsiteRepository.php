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
use Plugins\Tenancy\Repositories\Interfaces\WebsiteRepository as Contract;
use Plugins\Tenancy\Events\Websites as Events;
use Plugins\Tenancy\Contracts\Website;
use Plugins\Tenancy\Traits\DispatchesEvents;
use Plugins\Tenancy\Validators\WebsiteValidator;
use Illuminate\Database\Eloquent\Builder;

class EloquentWebsiteRepository extends RepositoriesAbstract implements Contract
{
    use DispatchesEvents;

    /**
     * @param string $uuid
     * @return Builder|\Illuminate\Database\Eloquent\Model|object|Website|null
     */
    public function findByUuid(string $uuid)
    {
        return $this->query()->where('uuid', $uuid)->first();
    }

    /**
     * @param Website $website
     * @return Website
     */
    public function createFromCollection(Website &$website): Website
    {
        if ($website->exists) {
            return $this->updateFromCollection($website);
        }

        $this->emitEvent(
            new Events\Creating($website)
        );

        app()->make(WebsiteValidator::class)->save($website);

        $website->save();

        $this->emitEvent(
            new Events\Created($website)
        );

        return $website;
    }

    /**
     * @param Website $website
     * @param string $tenantName
     * @return Website
     */
    public function createFromModelWithData(Website &$website, string $tenantName): Website
    {
        if ($website->exists) {
            return $this->updateFromCollection($website);
        }

        $this->emitEvent(
            new Events\Creating($website, $tenantName)
        );

        app()->make(WebsiteValidator::class)->save($website);

        $website->save();

        $this->emitEvent(
            new Events\Created($website)
        );

        return $website;
    }

    /**
     * @param Website $website
     * @return Website
     */
    public function updateFromCollection(Website &$website): Website
    {
        if (!$website->exists) {
            return $this->createFromCollection($website);
        }

        $this->emitEvent(
            new Events\Updating($website)
        );

        app()->make(WebsiteValidator::class)->save($website);

        $dirty = collect(array_keys($website->getDirty()))->mapWithKeys(function ($value, $key) use ($website) {
            return [ $value => $website->getOriginal($value) ];
        });

        $website->save();

        $this->emitEvent(
            new Events\Updated($website, $dirty->toArray())
        );

        return $website;
    }

    /**
     * @param Website $website
     * @param bool $hard
     * @return Website
     */
    public function deleteFromCollection(Website &$website, $hard = false): Website
    {
        $this->emitEvent(
            new Events\Deleting($website)
        );

        app()->make(WebsiteValidator::class)->delete($website);

        $hard ? $website->forceDelete() : $website->delete();

        $this->emitEvent(
            new Events\Deleted($website)
        );

        return $website;
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
