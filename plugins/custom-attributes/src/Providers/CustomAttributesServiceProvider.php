<?php

namespace Plugins\CustomAttributes\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\CustomAttributes\Repositories\Caches\CacheCustomAttributesRepositories;
use Plugins\CustomAttributes\Repositories\Eloquent\EloquentCustomAttributesRepositories;
use Plugins\CustomAttributes\Repositories\Interfaces\AttributeValueStringRepositories;
use Plugins\CustomAttributes\Repositories\Interfaces\CustomAttributesRepositories;
use Plugins\CustomAttributes\Services\CustomAttributeServices;
use Plugins\CustomAttributes\Services\Implement\ImplementCustomAttributeServices;

class CustomAttributesServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Prefix support binding eloquent
     * @author TrinhLe
     */
    const PREFIX_REPOSITORY_ELOQUENT = 'Eloquent\\Eloquent';

    /**
     * Prefix support binding cache
     * @author TrinhLe
     */
    const PREFIX_REPOSITORY_CACHE = 'Caches\\Cache';

    /**
     * @author AnhPham
     */
    public function register()
    {
        register_repositories($this);
        $this->app->singleton(CustomAttributeServices::class, ImplementCustomAttributeServices::class);
    }

    /**
     * @return array
     */
    public function getRespositories():array
    {
        return [
            CustomAttributesRepositories::class  => \Plugins\CustomAttributes\Models\CustomAttributes::class,
            AttributeValueStringRepositories::class  => \Plugins\CustomAttributes\Models\CustomAttributeValueString::class,
        ];
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        
    }
}
