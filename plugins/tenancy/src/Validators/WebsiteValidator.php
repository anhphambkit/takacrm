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

namespace Plugins\Tenancy\Validators;

use Plugins\Tenancy\Abstracts\Validator;

class WebsiteValidator extends Validator
{
    protected $create = [
        'uuid' => ['required', 'string', "unique:%system%.%websites%,uuid"],
    ];
    protected $update = [
        'uuid' => ['required', 'string', "unique:%system%.%websites%,uuid,%id%"],
    ];
}
