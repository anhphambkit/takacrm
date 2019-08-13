<?php

namespace Plugins\Blog;

use Artisan;
use Core\Master\Supports\PermissionCommand;
use Schema;
class Plugin
{
    /**
     * @param null $databaseConnection
     */
    public static function activate($databaseConnection = null)
    {
        $databaseConnection = !empty($databaseConnection) ? $databaseConnection : config('database.default');
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/blog/database/migrations',
            '--database' => $databaseConnection,
        ]);
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => "plugins/blog/database/migrations/{$databaseConnection}",
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
     * @param null $databaseConnection
     */
    public static function remove($databaseConnection = null)
    {
        $databaseConnection = !empty($databaseConnection) ? $databaseConnection : config('database.default');
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => 'plugins/blog/database/migrations',
            '--database' => $databaseConnection,
        ]);
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => "plugins/blog/database/migrations/{$databaseConnection}",
            '--database' => $databaseConnection,
        ]);
    }
}