<?php

namespace Plugins\Newsletter\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Newsletter\Repositories\Caches\CacheNewsletterRepositories;
use Plugins\Newsletter\Repositories\Eloquent\EloquentNewsletterRepositories;
use Plugins\Newsletter\Repositories\Interfaces\NewsletterRepositories;

class NewsletterServiceProvider extends ServiceProvider
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
            $this->app->singleton(NewsletterRepositories::class, function () {
                return new CacheNewsletterRepositories(new EloquentNewsletterRepositories(new \Plugins\Newsletter\Models\Newsletter()));
            });
        } else {
            $this->app->singleton(NewsletterRepositories::class, function () {
                return new EloquentNewsletterRepositories(new \Plugins\Newsletter\Models\Newsletter());
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
