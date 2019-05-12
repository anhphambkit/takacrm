<?php

namespace Core\Setting\Providers;

use Core\Setting\Facades\SettingFacade;
use Core\Setting\Models\Setting as SettingModel;
use Core\Setting\Repositories\Cache\CacheReferenceRepositories;
use Core\Setting\Repositories\Eloquent\EloquentAddressGeneralInfoRepositories;
use Core\Setting\Repositories\Eloquent\EloquentReferenceRepositories;
use Core\Setting\Repositories\Interfaces\AddressGeneralInfoRepositories;
use Core\Setting\Repositories\Interfaces\ReferenceRepositories;
use Core\Setting\Services\AddressGeneralInfoService;
use Core\Setting\Services\Implement\ImplementAddressGeneralInfoService;
use Core\Setting\Services\Implement\ImplementReferenceServices;
use Core\Setting\Services\ReferenceServices;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Core\Setting\Repositories\Interfaces\SettingRepositories;
use Core\Setting\Repositories\Eloquent\EloquentSettingRepositories;
use Core\Setting\Repositories\Cache\CacheSettingRepositories;

class SettingServiceProvider extends ServiceProvider
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
        AliasLoader::getInstance()->alias('Setting', SettingFacade::class);

        if (setting('enable_cache', false)) {

            $this->app->singleton(SettingRepositories::class, function () {
                return new CacheSettingRepositories(new EloquentSettingRepositories(new \Core\Setting\Models\Setting()));
            });

            $this->app->singleton(ReferenceRepositories::class, function () {
                return new CacheReferenceRepositories(new EloquentReferenceRepositories(new \Core\Setting\Models\Reference()));
            });
            
        } else {

            $this->app->singleton(SettingRepositories::class, function () {
                return new EloquentSettingRepositories(new \Core\Setting\Models\Setting());
            });

            $this->app->singleton(ReferenceRepositories::class, function () {
                return new EloquentReferenceRepositories(new \Core\Setting\Models\Reference());
            });
        }

        // Reference:
        $this->app->singleton(ReferenceServices::class, ImplementReferenceServices::class);

        // Bind Address General:
        $this->app->singleton(AddressGeneralInfoService::class, ImplementAddressGeneralInfoService::class);
        $this->app->singleton(AddressGeneralInfoRepositories::class, EloquentAddressGeneralInfoRepositories::class);
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        $this->publishes([
            base_path('core/setting/src/Data/') => storage_path('app/public')
        ], 'storage');
    }
}
