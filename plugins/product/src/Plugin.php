<?php

namespace Plugins\Product;

use Artisan;
use Core\Master\Supports\PermissionCommand;
use Schema;
class Plugin
{
    /**
     * @author AnhPham
     */
    public static function activate()
    {
        $databaseConnection = config('core-base.cms.current_database_connection');
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/product/database/migrations',
            '--database' => $databaseConnection,
        ]);
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => "plugins/product/database/migrations/{$databaseConnection}",
            '--database' => $databaseConnection,
        ]);
    }

    /**
     * @author AnhPham
     */
    public static function deactivate()
    {

    }

    /**
     * @author AnhPham
     */
    public static function remove()
    {
        $databaseConnection = config('core-base.cms.current_database_connection');
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => 'plugins/product/database/migrations',
            '--database' => $databaseConnection,
        ]);
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => "plugins/product/database/migrations/{$databaseConnection}",
            '--database' => $databaseConnection,
        ]);
    }
}