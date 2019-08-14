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

namespace Plugins\Tenancy\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;
use Plugins\Tenancy\Contracts\Website;
use Illuminate\Database\Eloquent\Builder;

interface WebsiteRepository extends RepositoryInterface
{
    /**
     * @param string $uuid
     * @return Website|null
     */
    public function findByUuid(string $uuid);

    /**
     * @param Website $website
     * @return Website
     */
    public function createFromCollection(Website &$website): Website;

    /**
     * @param Website $website
     * @param string $tenantName
     * @return Website
     */
    public function createFromModelWithData(Website &$website, string $tenantName): Website;

    /**
     * @param Website $website
     * @return Website
     */
    public function updateFromCollection(Website &$website): Website;
    /**
     * @param Website $website
     * @param bool $hard
     * @return Website
     */
    public function deleteFromCollection(Website &$website, $hard = false): Website;

    /**
     * @warn Only use for querying.
     * @return Builder
     */
    public function query(): Builder;
}
