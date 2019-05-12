<?php

namespace Plugins\Faq\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Faq\Repositories\Caches\CacheFaqRepositories;
use Plugins\Faq\Repositories\Eloquent\EloquentFaqRepositories;
use Plugins\Faq\Repositories\Interfaces\FaqRepositories;

class FaqServiceProvider extends ServiceProvider
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
            $this->app->singleton(FaqRepositories::class, function () {
                return new CacheFaqRepositories(new EloquentFaqRepositories(new \Plugins\Faq\Models\Faq()));
            });
        } else {
            $this->app->singleton(FaqRepositories::class, function () {
                return new EloquentFaqRepositories(new \Plugins\Faq\Models\Faq());
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
