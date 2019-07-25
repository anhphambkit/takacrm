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

namespace Plugins\Tenancy\Database\Console\Seeds;

use Plugins\Tenancy\Traits\MutatesSeedCommands;
use Illuminate\Database\Console\Seeds\SeedCommand as BaseCommand;

class SeedCommand extends BaseCommand
{
    use MutatesSeedCommands;
}
