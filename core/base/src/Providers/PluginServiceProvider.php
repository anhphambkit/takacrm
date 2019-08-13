<?php

namespace Core\Base\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Schema;
use Core\Master\Supports\LoadRegisterTrait;

class PluginServiceProvider extends ServiceProvider
{
    use LoadRegisterTrait;

    /**
     * @author TrinhLe
     * @param PluginInterface $pluginRepository
     */
    public function boot()
    {
        $plugins = $this->loadPluginAvailable();
        foreach ($plugins as $plugin) {
            if (class_exists($plugin->provider)) {
                $this->app->register($plugin->provider);
            }
        }
    }
}