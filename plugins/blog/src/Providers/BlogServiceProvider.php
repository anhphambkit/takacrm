<?php

namespace Plugins\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Plugins\Blog\Repositories\Caches\CacheBlogRepositories;
use Plugins\Blog\Repositories\Eloquent\EloquentBlogRepositories;
use Plugins\Blog\Repositories\Interfaces\BlogRepositories;

use Plugins\Blog\Repositories\Interfaces\PostRepositories;
use Plugins\Blog\Repositories\Eloquent\EloquentPostRepositories;
use Plugins\Blog\Repositories\Caches\CachePostRepositories;

use Plugins\Blog\Repositories\Interfaces\CategoryRepositories;
use Plugins\Blog\Repositories\Eloquent\EloquentCategoryRepositories;
use Plugins\Blog\Repositories\Caches\CacheCategoryRepositories;

use Plugins\Blog\Repositories\Interfaces\TagRepositories;
use Plugins\Blog\Repositories\Eloquent\EloquentTagRepositories;
use Plugins\Blog\Repositories\Caches\CacheTagRepositories;

class BlogServiceProvider extends ServiceProvider
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
            $this->app->singleton(BlogRepositories::class, function () {
                return new CacheBlogRepositories(new EloquentBlogRepositories(new \Plugins\Blog\Models\Blog()));
            });

            $this->app->singleton(PostRepositories::class, function () {
                return new CachePostRepositories(new EloquentPostRepositories(new \Plugins\Blog\Models\Post()));
            });

            $this->app->singleton(CategoryRepositories::class, function () {
                return new CacheCategoryRepositories(new EloquentCategoryRepositories(new \Plugins\Blog\Models\Category()));
            });

            $this->app->singleton(TagRepositories::class, function () {
                return new CacheTagRepositories(new EloquentTagRepositories(new \Plugins\Blog\Models\Tag()));
            });
        } else {
            $this->app->singleton(BlogRepositories::class, function () {
                return new EloquentBlogRepositories(new \Plugins\Blog\Models\Blog());
            });

            $this->app->singleton(PostRepositories::class, function () {
                return new EloquentPostRepositories(new \Plugins\Blog\Models\Post());
            });

            $this->app->singleton(CategoryRepositories::class, function () {
                return new EloquentCategoryRepositories(new \Plugins\Blog\Models\Category());
            });

            $this->app->singleton(TagRepositories::class, function () {
                return new EloquentTagRepositories(new \Plugins\Blog\Models\Tag());
            });
        }
    }

    /**
     * @author TrinhLe
     */
    public function boot()
    {
        $screens = [BLOG_POST_MODULE_SCREEN_NAME, BLOG_CATEGORY_MODULE_SCREEN_NAME, BLOG_TAG_MODULE_SCREEN_NAME];
        $prefixes = [
            BLOG_POST_MODULE_SCREEN_NAME     => '/blog/post/',
            BLOG_CATEGORY_MODULE_SCREEN_NAME => 'blog/category/',
            BLOG_TAG_MODULE_SCREEN_NAME      => '/blog/tag/'
        ];


        $this->app->booted(function () use ($screens, $prefixes){
            config([
                'core-slug.general.supported' => array_merge(config('core-slug.general.supported'), $screens),
            ]);

            config([
                'core-slug.general.prefixes' => array_merge(config('core-slug.general.prefixes'), $prefixes),
            ]);
        });
    }
}
