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

namespace Plugins\Tenancy\Providers\Tenants;

use Plugins\Tenancy\Contracts\Bus\Dispatcher as DispatcherContract;
use Illuminate\Bus\Dispatcher;
use Illuminate\Support\ServiceProvider;

class BusProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(DispatcherContract::class, function ($app) {
            return new Dispatcher($app);
        });
    }
}
