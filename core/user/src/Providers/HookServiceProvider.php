<?php

namespace Core\User\Providers;

use Illuminate\Support\ServiceProvider;
use Core\User\Audit\AuditHook;

class HookServiceProvider extends ServiceProvider
{
    /**
     * @author TrinhLe
     */
    public function boot()
    {
        add_action(AUTH_ACTION_AFTER_LOGIN_SYSTEM, [AuditHook::class, 'handleLogin'], 45, 3);
        add_action(AUTH_ACTION_AFTER_LOGOUT_SYSTEM, [AuditHook::class, 'handleLogout'], 45, 3);
        add_action(USER_ACTION_AFTER_UPDATE_PASSWORD, [AuditHook::class, 'handleUpdatePassword'], 45, 3);
        add_action(USER_ACTION_AFTER_UPDATE_PASSWORD, [AuditHook::class, 'handleUpdateProfile'], 45, 3);
    }
}
