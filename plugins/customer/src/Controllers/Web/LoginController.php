<?php

namespace Plugins\Customer\Controllers\Web;
use Illuminate\Http\Request;
use Core\Base\Controllers\Web\BasePublicController;
use Core\User\Traits\LogoutGuardTrait;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use URL;

class LoginController extends BasePublicController
{
	/*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, LogoutGuardTrait {
        LogoutGuardTrait::logout insteadof AuthenticatesUsers;
    }

    use AuthenticatesUsers {
        attemptLogin as baseAttemptLogin;
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    public $redirectTo;

    /**
     * Create a new controller instance.
     *
     * @return void
     * @author Trinh Le
     */
    public function __construct()
    {
        session(['url.intended' => URL::previous()]);
        if (session()->get('url.intended') === route('public.customer.login')) {
            $this->redirectTo = route('public.customer.dashboard');
        } else {
            $this->redirectTo = session()->get('url.intended');
        }
    }

    /**
     * Show the application's login form.
     *
     * @return \Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @author Trinh Le
     */
    public function showLoginForm()
    {
        // SeoHelper::setTitle(trans('plugins/member::member.login'));
        return view('plugins-customer::auth.login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     * @author Trinh Le
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Validation\ValidationException
     * @author Trinh Le
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     * @throws ValidationException
     * @author Trinh Le
     */
    protected function attemptLogin(Request $request)
    {
        if ($this->guard()->validate($this->credentials($request))) {
            $member = $this->guard()->getLastAttempted();

            if(!$member->status){
            	throw ValidationException::withMessages([
                    'block' => [
                        trans('plugins-customer::customer.block')
                    ],
                ]);
            }

            if (config('plugins-customer.general.verify_email') && empty($member->confirmed_at)) {
                throw ValidationException::withMessages([
                    'confirmation' => [
                        trans('plugins-customer::customer.not_confirmed', [
                            'resend_link' => route('public.customer.resend_confirmation', ['email' => $member->email]),
                        ]),
                    ],
                ]);
            }

            return $this->baseAttemptLogin($request);
        }
        return false;
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

}