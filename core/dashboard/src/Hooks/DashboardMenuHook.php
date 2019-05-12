<?php
namespace Core\Dashboard\Hooks;
use Illuminate\Http\Request;

class DashboardMenuHook
{
    /**
     * Register main menu system
     * @author TrinhLe
     * @return html
     */
    public static function renderMenuDashboard($currentRoute)
    {
        $active = false;
        $route = 'admin.dashboard.index';
        $title = __('TAKABOOK DASHBOARD');

        if ($currentRoute == $route) {
            $active = true;
        }
        return view('core-dashboard::menu.title',compact('active','route','title'))->render();
    }
}