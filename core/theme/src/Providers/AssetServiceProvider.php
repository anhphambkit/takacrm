<?php

namespace Core\Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Core\Theme\Foundation\Asset\Manager\CmsAssetManager;
use Core\Theme\Foundation\Asset\Manager\AssetManager;
use Core\Theme\Foundation\Asset\Pipeline\CmsAssetPipeline;
use Core\Theme\Foundation\Asset\Pipeline\AssetPipeline;
use Illuminate\Foundation\AliasLoader;
use Core\Theme\Facades\AssetManagerFacade;
use Core\Theme\Facades\AssetPipelineFacade;
use Core\Theme\Facades\AssetTypeFactoryFacade;
use Event;
use Illuminate\Routing\Events\RouteMatched;

class AssetServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Foundation\Application
     */
    protected $app;

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->bindAssetClasses();
        $this->registerFacades();

        #============Assets============#
        $this->registerComposers();
    }

    /**
     * Binding containers
     * @return mixed
     */
    public function boot()
    {
        Event::listen(RouteMatched::class, function () {
            $this->registerAssets();
        });
    }

    /**
     * Bind classes related to assets
     */
    protected function bindAssetClasses()
    {
        $this->app->singleton(AssetManager::class, function () {
            return new CmsAssetManager();
        });

        $this->app->singleton(AssetPipeline::class, function ($app) {
            return new CmsAssetPipeline($app[AssetManager::class]);
        });
    }

    /**
     * Register facades for theme assets
     * @author TrinhLe
     */
    protected function registerFacades()
    {
        $loader = AliasLoader::getInstance();
        $loader->alias('AssetManager', AssetManagerFacade::class);
        $loader->alias('AssetPipeline', AssetPipelineFacade::class);
        $loader->alias('AssetTypeFactory', AssetTypeFactoryFacade::class);
    }

    /**
     * Register assets for systems
     * @author TrinhLe
     */
    protected function registerAssets()
    {
        if(!app()->runningInConsole())
        {
            $assets = $cssRequired = $jsRequired = array();
            if ($this->inAdministration() === false) {
                $assets      = config('resources.frontend-assets');
                $cssRequired = config('resources.frontend-required-assets.css');
                $jsRequired  = config('resources.frontend-required-assets.js');
            }else
            {
                $assets      = config('resources.admin-assets');
                $cssRequired = config('resources.admin-required-assets.css');
                $jsRequired  = config('resources.admin-required-assets.js');
                 $editor = setting('rich_editor', config('core-base.cms.editor.primary'));
                $jsRequired[] = "{$editor}-js";
            }
            
            foreach ($assets as $assetName => $path) {
                $path = asset_type_factory()->make($path)->url();
                asset_manager()->addAsset($assetName, $path);
            }
            asset_pipeline()->requireCss($cssRequired);
            asset_pipeline()->requireJs($jsRequired);
        }
    }

    /**
     * Check if we are in the administration
     * @author TrinhLe
     * @return bool
     */
    protected function inAdministration()
    {
        $segment = 1;
        return $this->app['request']->segment($segment) === config('core-base.cms.router-prefix.admin');
    }

    /**
     * Register view composer assets
     * @author TrinhLe
     */
    protected function registerComposers()
    {
        view()->composer('layouts.master', \Core\Theme\Composers\AssetsViewComposer::class);
        view()->composer('layouts.front-end', \Core\Theme\Composers\AssetsViewComposer::class);
    }
}
