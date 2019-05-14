<?php

namespace Plugins\Product\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Product\Repositories\Caches\CacheLookBookRepositories;
use Plugins\Product\Repositories\Caches\CacheProductCategoryRepositories;
use Plugins\Product\Repositories\Caches\CacheProductSpaceRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentLookBookRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductCategoryRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductSpaceRepositories;
use Plugins\Product\Repositories\Interfaces\LookBookRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories;
use Plugins\Product\Repositories\Caches\CacheManufacturerRepositories;
use Plugins\Product\Repositories\Caches\CacheBusinessTypeRepositories;
use Plugins\Product\Repositories\Caches\CacheProductCollectionRepositories;
use Plugins\Product\Repositories\Caches\CacheProductColorRepositories;
use Plugins\Product\Repositories\Caches\CacheProductMaterialRepositories;
use Plugins\Product\Repositories\Caches\CacheProductRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentManufacturerRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentBusinessTypeRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductCollectionRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductColorRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductMaterialRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductRepositories;
use Plugins\Product\Repositories\Interfaces\ManufacturerRepositories;
use Plugins\Product\Repositories\Interfaces\BusinessTypeRepositories;
use Plugins\Product\Repositories\Interfaces\ProductCollectionRepositories;
use Plugins\Product\Repositories\Interfaces\ProductColorRepositories;
use Plugins\Product\Repositories\Interfaces\ProductMaterialRepositories;
use Plugins\Product\Repositories\Interfaces\ProductOriginRepositories;
use Plugins\Product\Repositories\Interfaces\ProductRepositories;
use Plugins\Product\Repositories\Interfaces\ProductSpaceRepositories;
use Plugins\Product\Repositories\Interfaces\ProductUnitRepositories;
use Plugins\Product\Services\BusinessTypeServices;
use Plugins\Product\Services\Implement\ImplementBusinessTypeServices;
use Plugins\Product\Services\Implement\ImplementLookBookServices;
use Plugins\Product\Services\Implement\ImplementProductCategoryServices;
use Plugins\Product\Services\Implement\ImplementProductServices;
use Plugins\Product\Services\Implement\ImplementProductSpaceServices;
use Plugins\Product\Services\LookBookServices;
use Plugins\Product\Services\ProductCategoryServices;
use Plugins\Product\Services\ProductServices;
use Plugins\Product\Repositories\Interfaces\ProductCouponRepositories;
use Plugins\Product\Repositories\Eloquent\EloquentProductCouponRepositories;
use Plugins\Product\Repositories\Caches\CacheProductCouponRepositories;
use Plugins\Product\Services\ProductSpaceServices;


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
     * Get config repositories
     * @author TrinhLe
     * @return [array] [description]
     */
    public function getRespositories():array
    {
        return [
            ProductRepositories::class           => \Plugins\Product\Models\Product::class,
            ManufacturerRepositories::class      => \Plugins\Product\Models\ProductManufacturer::class,
            ProductCategoryRepositories::class   => \Plugins\Product\Models\ProductCategory::class,
            ProductUnitRepositories::class   => \Plugins\Product\Models\ProductUnit::class,
            ProductOriginRepositories::class   => \Plugins\Product\Models\ProductOrigin::class,
        ];
    }

    /**
     * @author AnhPham
     */
    public function boot(){}
}
