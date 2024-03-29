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

namespace Plugins\Tenancy\Providers;

use Plugins\Tenancy\Commands\RunCommand;
use Plugins\Tenancy\Contracts;
use Plugins\Tenancy\Listeners\Database\FlushHostnameCache;
use Plugins\Tenancy\Environment;
use Plugins\Tenancy\Repositories;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Plugins\Tenancy\Commands\InstallCommand;
use Plugins\Tenancy\Commands\RecreateCommand;
use Plugins\Tenancy\Providers\Tenants as Providers;
use Plugins\Tenancy\Contracts\Website as WebsiteContract;
use Plugins\Tenancy\Contracts\Hostname as HostnameContract;

class TenancyProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../assets/configs/tenancy.php',
            'tenancy'
        );

        $this->registerModels();

        $this->registerProviders();

        $this->registerMiddleware();
    }

    public function boot()
    {
        $this->bootCommands();

        $this->bootEnvironment();
    }

    protected function registerModels()
    {
        $config = $this->app['config']['tenancy.models'];

        $this->app->bind(HostnameContract::class, $config['hostname']);
        $this->app->bind(WebsiteContract::class, $config['website']);

        forward_static_call([$config['hostname'], 'observe'], FlushHostnameCache::class);
    }

    protected function registerProviders()
    {
        $this->app->register(Providers\ConfigurationProvider::class);
        $this->app->register(Providers\PasswordProvider::class);
        $this->app->register(Providers\ConnectionProvider::class);
        $this->app->register(Providers\UuidProvider::class);
        $this->app->register(Providers\BusProvider::class);
        $this->app->register(Providers\FilesystemProvider::class);
        $this->app->register(Providers\HostnameProvider::class);
        $this->app->register(Providers\DatabaseDriverProvider::class);

        // Register last.
        $this->app->register(Providers\EventProvider::class);
        $this->app->register(Providers\RouteProvider::class);
    }

    protected function bootCommands()
    {
        $this->commands([
            RecreateCommand::class,
            RunCommand::class
        ]);
    }

    protected function bootEnvironment()
    {
        // Immediately instantiate the object to work the magic.
        $environment = $this->app->make(Environment::class);
        // Now register it into ioc to make it globally available.
        $this->app->singleton(Environment::class, function () use ($environment) {
            return $environment;
        });

        $this->app->alias(Environment::class, 'tenancy-environment');
    }

    protected function registerMiddleware()
    {
        $middleware = $this->app['config']['tenancy.middleware'];

        /** @var Kernel|\Illuminate\Foundation\Http\Kernel $kernel */
        $kernel = $this->app->make(Kernel::class);

        foreach ($middleware as $mw) {
            $kernel->prependMiddleware($mw);
        }
    }

    public function provides()
    {
        return [
            Environment::class,
            Contracts\Tenant::class,
            Contracts\CurrentHostname::class,
        ];
    }
}
