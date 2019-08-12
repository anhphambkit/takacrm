<?php

namespace Plugins\CustomAttributes;

use Artisan;
use Core\Master\Supports\PermissionCommand;
use Schema;
class Plugin
{
    /**
     * @author TrinhLe
     */
    public static function activate()
    {
        $databaseConnection = config('core-base.cms.current_database_connection');
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/custom-attributes/database/migrations',
            '--database' => $databaseConnection,
        ]);
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => "plugins/custom-attributes/database/migrations/{$databaseConnection}",
            '--database' => $databaseConnection,
        ]);
    }

    /**
     * @author TrinhLe
     */
    public static function deactivate()
    {

    }

    /**
     * @author TrinhLe
     */
    public static function remove()
    {
        $databaseConnection = config('core-base.cms.current_database_connection');
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => 'plugins/custom-attributes/database/migrations',
            '--database' => $databaseConnection,
        ]);
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => "plugins/custom-attributes/database/migrations/{$databaseConnection}",
            '--database' => $databaseConnection,
        ]);
    }
}