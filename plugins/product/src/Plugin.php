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
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/product/database/migrations',
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
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => 'plugins/product/database/migrations',
        ]);
    }
}