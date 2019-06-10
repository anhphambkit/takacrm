<?php

namespace Plugins\History\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\History\Repositories\Caches\CacheHistoryRepositories;
use Plugins\History\Repositories\Eloquent\EloquentHistoryRepositories;
use Plugins\History\Repositories\Interfaces\HistoryRepositories;

class HistoryServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * @author TrinhLe
     */
    public function register()
    {
        if (setting('enable_cache', false)) {
            $this->app->singleton(HistoryRepositories::class, function () {
                return new CacheHistoryRepositories(new EloquentHistoryRepositories(new \Plugins\History\Models\History()));
            });
        } else {
            $this->app->singleton(HistoryRepositories::class, function () {
                return new EloquentHistoryRepositories(new \Plugins\History\Models\History());
            });
        }
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
