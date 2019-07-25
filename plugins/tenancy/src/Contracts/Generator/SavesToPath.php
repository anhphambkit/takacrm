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

namespace Plugins\Tenancy\Contracts\Generator;

use Plugins\Tenancy\Contracts\Website;

interface SavesToPath
{
    /**
     * @param Website $website
     * @return string
     */
    public function targetPath(Website $website): string;
}
