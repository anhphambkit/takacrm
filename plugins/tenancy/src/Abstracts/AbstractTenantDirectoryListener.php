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

use Plugins\Tenancy\Events\Websites\Identified;
use Plugins\Tenancy\Events\Websites\Switched;
use Plugins\Tenancy\Website\Directory;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Filesystem\Filesystem;

abstract class AbstractTenantDirectoryListener
{
    /**
     * @var string
     */
    protected $configBaseKey;
    /**
     * @var string
     */
    protected $path;
    /**
     * @var Filesystem
     */
    protected $filesystem;
    /**
     * @var Repository
     */
    protected $config;
    /**
     * @var Directory
     */
    protected $directory;

    /**
     * Event has to have a Website object to work.
     *
     * @var bool
     */
    protected $requiresWebsite = true;

    /**
     * Path has to exist in tenant directory.
     *
     * @var bool
     */
    protected $requiresPath = true;

    /**
     * @var bool
     */
    protected $tenantFilesystemEnabled;

    public function __construct(Filesystem $filesystem, Repository $config, Directory $directory)
    {
        $this->filesystem = $filesystem;
        $this->config = $config;
        $this->directory = $directory;
        $this->tenantFilesystemEnabled = $config->get('tenancy.website.disk') !== false;
    }

    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        if ($this->tenantFilesystemEnabled && $this->config->get("{$this->configBaseKey}.enabled")) {
            $events->listen([Identified::class, Switched::class], [$this, 'proxy']);
        }
    }

    /**
     * Proxies fired events to configure the handler.
     * @param WebsiteEvent $event
     */
    public function proxy(WebsiteEvent $event)
    {
        if ($event->website) {
            $this->directory->setWebsite($event->website);
        } elseif ($this->requiresWebsite) {
            return;
        }

        if ($this->requiresPath && !$this->exists()) {
            return;
        }

        $result = $this->load($event);

        // Possible after processing.

        return $result;
    }

    /**
     * @param WebsiteEvent $event
     * @return void
     */
    abstract public function load(WebsiteEvent $event);

    /**
     * @return bool
     */
    protected function exists(): bool
    {
        if (!$this->directory->getWebsite()) {
            return false;
        }

        return $this->directory->exists($this->path);
    }

    /**
     * @return string
     */
    protected function path()
    {
        return $this->directory->path($this->path);
    }
}
