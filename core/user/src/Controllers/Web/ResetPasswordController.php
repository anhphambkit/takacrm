<?php

namespace Core\User\Controllers\Web;

use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Config\Repository;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends BasePublicController
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @param Repository $config
     */
    public function __construct(Repository $config)
    {
        $this->middleware('guest');
        $this->redirectTo = $config->get('core-base.cms.admin_dir');
    }

    /**
     * @param Request $request
     * @param null $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('core-user::auth.reset', compact('email', 'token'));
    }
}
