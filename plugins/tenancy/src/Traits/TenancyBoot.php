<?php
/**
 * Created by PhpStorm.
 * User: AnhPham
 * Date: 2019-08-09
 * Time: 14:06
 */

namespace Plugins\Tenancy\Traits;

use Core\Master\Supports\LoadRegisterTrait;

trait TenancyBoot
{
    use LoadRegisterTrait;

    /**
     * Description
     * @author TrinhLe
     */
    protected function publishMigrationTenancy()
    {
        if (app()->environment() !== 'testing')
        {
            if ($this->app->runningInConsole()) {

                $sources = $this->loadPackages(TENANCY_SOURCE_MIGRATIONS);
                foreach ($sources as $group => $dir) {
                    $this->publishes([
                        $dir => config('tenancy.db.tenant-migrations-path'),
                    ], 'tenant-migrations');
                }
            }
        }
    }
}