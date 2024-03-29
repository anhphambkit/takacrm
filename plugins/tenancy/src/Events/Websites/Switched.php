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

namespace Plugins\Tenancy\Events\Websites;

use Plugins\Tenancy\Abstracts\WebsiteEvent;
use Plugins\Tenancy\Contracts\Website;

class Switched extends WebsiteEvent
{
    /**
     * @var Website
     */
    public $old;

    /**
     * @param Website $website
     * @return $this
     */
    public function setOld(Website $website)
    {
        $this->old = $website;

        return $this;
    }
}
