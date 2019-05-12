<?php

namespace Core\Media\Providers;

use Core\Media\Facades\BMediaFacade;
use Core\Media\Facades\BFileServiceFacade;

use Core\Media\Models\MediaSetting;
use Core\Media\Models\MediaFolder;
use Core\Media\Models\MediaShare;
use Core\Media\Models\MediaFile;
use Core\User\Models\User;
use Core\Media\Repositories\Interfaces\MediaSettingRepositories;
use Core\Media\Repositories\Eloquent\EloquentMediaSettingRepositories;
use Core\Media\Repositories\Cache\CacheMediaSettingRepositories;

use Core\Media\Repositories\Interfaces\MediaFileRepositories;
use Core\Media\Repositories\Eloquent\EloquentMediaFileRepositories;
use Core\Media\Repositories\Cache\CacheMediaFileRepositories;

use Core\Media\Repositories\Interfaces\MediaFolderRepositories;
use Core\Media\Repositories\Eloquent\EloquentMediaFolderRepositories;
use Core\Media\Repositories\Cache\CacheMediaFolderRepositories;

use Core\Media\Repositories\Interfaces\MediaShareRepositories;
use Core\Media\Repositories\Eloquent\EloquentMediaShareRepositories;
use Core\Media\Repositories\Cache\CacheMediaShareRepositories;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

use Core\Media\Image\ThumbnailManager;
use Core\Media\Image\ThumbnailManagerRepository;
use Intervention\Image\ImageServiceProvider;
use Core\Media\Image\Intervention\InterventionFactory;
use Core\Media\Image\ImageFactoryInterface;
use Intervention\Image\Facades\Image;
use Core\Media\Image\Imagy;
/**
 * Class MediaServiceProvider
 * @package Core\Media
 * @author TrinhLe
 */
class MediaServiceProvider extends ServiceProvider
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
        $this->app->register(ImageServiceProvider::class);
        $this->reigsterRepositories();

        AliasLoader::getInstance()->alias('BMedia', BMediaFacade::class);
        AliasLoader::getInstance()->alias('BFileService', BFileServiceFacade::class);


        $this->app->bind(ImageFactoryInterface::class, InterventionFactory::class);

        $this->app->singleton(ThumbnailManager::class, function () {
            return new ThumbnailManagerRepository();
        });

        $this->app->singleton('imagy', function ($app) {
            $factory = new InterventionFactory();

            return new Imagy($factory, $app[ThumbnailManager::class], $app['config']);
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Image', \Core\Media\Image\Facade\Imagy::class);
            $loader->alias('Imagy', \Core\Media\Image\Facade\Imagy::class);
        });

    }

    /**
     * Register list repo
     * @author TrinhLe
     */
    protected function reigsterRepositories()
    {
        if (setting('enable_cache_media', false)) {

            $this->app->singleton(MediaSettingRepositories::class, function () {
                return new CacheMediaSettingRepositories(new EloquentMediaSettingRepositories(new \Core\Media\Models\MediaSetting()));
            });

            $this->app->singleton(MediaFileRepositories::class, function () {
                return new CacheMediaFileRepositories(new EloquentMediaFileRepositories(new \Core\Media\Models\MediaFile()));
            });

            $this->app->singleton(MediaFolderRepositories::class, function () {
                return new CacheMediaFolderRepositories(new EloquentMediaFolderRepositories(new \Core\Media\Models\MediaFolder()));
            });

            $this->app->singleton(MediaShareRepositories::class, function () {
                return new CacheMediaShareRepositories(new EloquentMediaShareRepositories(new \Core\Media\Models\MediaShare()));
            });
            
        } else {

            $this->app->singleton(MediaSettingRepositories::class, function () {
                return new EloquentMediaSettingRepositories(new \Core\Media\Models\MediaSetting());
            });

            $this->app->singleton(MediaFileRepositories::class, function () {
                return new EloquentMediaFileRepositories(new \Core\Media\Models\MediaFile());
            });

            $this->app->singleton(MediaFolderRepositories::class, function () {
                return new EloquentMediaFolderRepositories(new \Core\Media\Models\MediaFolder());
            });

            $this->app->singleton(MediaShareRepositories::class, function () {
                return new EloquentMediaShareRepositories(new \Core\Media\Models\MediaShare());
            });
        }
    }

    /**
     * Boot the service provider.
     * @author TrinhLe
     */
    public function boot()
    {
       $this->registerThumbnails();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['imagy'];
    }

    /**
     * Register thumbnails 
     * @author  asgard
     * @return type
     */
    private function registerThumbnails()
    {
        $this->app[ThumbnailManager::class]->registerThumbnail('smallThumb', [
            'resize' => [
                'width' => 50,
                'height' => null,
                'callback' => function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                },
            ],
        ]);
        $this->app[ThumbnailManager::class]->registerThumbnail('mediumThumb', [
            'resize' => [
                'width' => 180,
                'height' => null,
                'callback' => function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                },
            ],
        ]);
    }
}
