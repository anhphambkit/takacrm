<?php

namespace Plugins\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;
use Plugins\Product\Repositories\Interfaces\ProductOriginRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Repositories\Interfaces\ProductUnitRepositories;
use Plugins\Product\Services\Implement\ImplementProductCategoryServices;
use Plugins\Product\Services\Implement\ImplementProductServices;
use Plugins\Product\Services\ProductCategoryServices;
use Plugins\Product\Services\ProductServices;

class ProductServiceProvider extends ServiceProvider
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
        $this->app->singleton(ProductServices::class, ImplementProductServices::class);
        $this->app->singleton(ProductCategoryServices::class, ImplementProductCategoryServices::class);
    }

    /**
     * @return array
     */
    public function getRepositories():array
    {
        return [
            ProductRepositories::class           => \Plugins\Product\Models\Product::class,
            ManufacturerRepositories::class      => \Plugins\Product\Models\ProductManufacturer::class,
            ProductCategoryRepositories::class   => \Plugins\Product\Models\ProductCategory::class,
            ProductUnitRepositories::class   => \Plugins\Product\Models\ProductUnit::class,
            ProductOriginRepositories::class   => \Plugins\Product\Models\ProductOrigin::class
        ];
    }

    /**
     * @author AnhPham
     */
    public function boot(){
        $this->publishes([ base_path('plugins/product/resources/app-assets') => public_path('plugins/product/app-assets')], 'product');
    }
}
