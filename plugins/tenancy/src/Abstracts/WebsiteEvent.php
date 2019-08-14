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

namespace Plugins\Tenancy\Abstracts;

use Plugins\Tenancy\Contracts\Website;

abstract class WebsiteEvent extends AbstractEvent
{
    /**
     * @var Website
     */
    public $website;

    /**
     * @var string
     */
    public $tenantName;

    /**
     * WebsiteEvent constructor.
     * @param Website $website
     * @param string|null $tenantName
     */
    public function __construct(Website &$website, string $tenantName = null)
    {
        $this->website = &$website;
        $this->tenantName = $tenantName;
    }
}
