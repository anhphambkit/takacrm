<?php
namespace Core\User\Audit;
use Core\User\Events\AuditHandlerEvent;
use Illuminate\Http\Request;
class AuditHook
{
	/**
     * @param $screen
     * @param Request $request
     * @param $data
     * @return string
     * @author TrinhLe
     */
    protected static function getReferenceName($screen, $request, $data)
    {
        $name = null;
        switch ($screen) {
            case USER_MODULE_SCREEN_NAME:
            case AUTH_MODULE_SCREEN_NAME:
                /**
                 * @var User $data
                 */
                $name = $data->getFullName();
                break;
            default:
                if (!empty($data)) {
                    if (isset($data->name)) {
                        $name = $data->name;
                    } elseif (isset($data->title)) {
                        $name = $data->title;
                    }
                }
        }
        return $name;
    }

     /**
     * @param $screen
     * @param Request $request
     * @param $data
     * @author TrinhLe
     */
    public static function handleLogin($screen, Request $request, $data)
    {
        event(new AuditHandlerEvent('to the system', 'logged in', $data->id, static::getReferenceName($screen, $request, $data), 'info'));
    }

    /**
     * @param $screen
     * @param Request $request
     * @param $data
     * @author TrinhLe
     */
    public static function handleLogout($screen, Request $request, $data)
    {
        event(new AuditHandlerEvent('of the system', 'logged out', $data->id, static::getReferenceName($screen, $request, $data), 'info'));
    }

    /**
     * @param $screen
     * @param Request $request
     * @param $data
     * @author TrinhLe
     */
    public static function handleUpdateProfile($screen, Request $request, $data)
    {
        event(new AuditHandlerEvent($screen, 'updated profile', $data->id, static::getReferenceName($screen, $request, $data), 'info'));
    }

    /**
     * @param $screen
     * @param Request $request
     * @param $data
     * @author TrinhLe
     */
    public static function handleUpdatePassword($screen, Request $request, $data)
    {
        event(new AuditHandlerEvent($screen, 'changed password', $data->id, static::getReferenceName($screen, $request, $data), 'danger'));
    }
}