<?php

namespace Core\Master\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Core\Master\Facades\ActionFacade;
use Core\Master\Facades\FilterFacade;
use Core\Master\Facades\DashboardMenuFacade;

use Core\Master\Facades\AdminBreadcrumbFacade;
use Core\Master\Facades\PageTitleFacade;
use Core\Master\Facades\MailVariableFacade;

class MasterServiceProvider extends ServiceProvider
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
        $loader = AliasLoader::getInstance();
        $loader->alias('Action', ActionFacade::class);
        $loader->alias('Filter', FilterFacade::class);
        $loader->alias('PageTitle', PageTitleFacade::class);
        $loader->alias('AdminBreadcrumb', AdminBreadcrumbFacade::class);
        $loader->alias('DashboardMenu', DashboardMenuFacade::class);
        $loader->alias('MailVariable', MailVariableFacade::class);
    }
}