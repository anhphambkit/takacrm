<?php

namespace Plugins\Order;

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
        Artisan::call('migrate', [
            '--force' => true,
            '--path' => 'plugins/order/database/migrations',
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
        Artisan::call('migrate:rollback', [
            '--force' => true,
            '--path' => 'plugins/order/database/migrations',
        ]);
    }
}