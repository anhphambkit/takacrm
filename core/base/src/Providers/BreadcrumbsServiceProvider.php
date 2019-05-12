<?php

namespace Core\Base\Providers;

use Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator as Generator;
use Illuminate\Support\ServiceProvider;

class BreadcrumbsServiceProvider extends ServiceProvider
{
    /**
     * @author Trinh Le
     */
    public function boot()
    {

        Breadcrumbs::register('', function (Generator $breadcrumbs) {
            $breadcrumbs->push('', '');
        });

        Breadcrumbs::register('admin.dashboard.index', function (Generator $breadcrumbs) {
            $breadcrumbs->push(trans('core-base::layouts.dashboard'), route('admin.dashboard.index'));
        });

        /**
         * Register breadcrumbs based on menu stored in session
         * @author Trinh Le
         */
        Breadcrumbs::register('pageTitle', function (Generator $breadcrumbs, $defaultTitle = 'pageTitle', $url) {

            $arMenu = dashboard_menu()->getAll();
            $breadcrumbs->parent('admin.dashboard.index');
            $found = false;
            foreach ($arMenu as $menuCategory) {
                if ($url == $menuCategory->url && !empty($menuCategory->name)) {
                    $found = true;
                    $breadcrumbs->push($menuCategory->name, $url);
                    break;
                }
            }
            if (!$found) {
                foreach ($arMenu as $menuCategory) {
                    if (isset($menuCategory->children)) {
                        foreach ($menuCategory->children as $menuItem) {
                            if ($url == $menuItem->url && !empty($menuItem->name)) {
                                $found = true;
                                $breadcrumbs->push($menuCategory->name, $menuCategory->url);
                                $breadcrumbs->push($menuItem->name, $url);
                                break;
                            }
                        }
                    }
                }
            }

            if (!$found) {
                $breadcrumbs->push($defaultTitle, $url);
            }
        });
    }
}
