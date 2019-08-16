<?php
namespace Core\User\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Core\User\Requests\LoginRequest;
use Illuminate\Validation\ValidationException;

class WebController extends BasePublicController{
    
    /**
     * Define login credential
     * @author TrinhLe
     * @var string
     */
    protected $username = 'email';

    /**
     * Login page
     * @author TrinhLe
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm(){

        return view('core-user::auth.login');
    }

    public function showHomePage() {
        return view('core-user::homepage');
    }

    /**
     * Validate login system
     * @author TrinhLe
     * @return mixed
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $remember = (bool) $request->get('remember_me', false);

        $error = $this->auth->login($credentials, $remember);
        
        if ($error) {
            throw ValidationException::withMessages([
                $this->username => [$error],
            ]);
        }
        // do_action(AUTH_ACTION_AFTER_LOGIN_SYSTEM, AUTH_MODULE_SCREEN_NAME, request(), acl_get_current_user());
        return redirect()->intended(route(REDIRECT_AFTER_LOGIN))
                ->withSuccess(__('Logged'));
    }

    /**
     * Logout
     * @author TrinhLe
     */
    public function logout()
    {
        // do_action(AUTH_ACTION_AFTER_LOGOUT_SYSTEM, AUTH_MODULE_SCREEN_NAME, request(), acl_get_current_user());
        $this->auth->logout();
        return redirect()->route('login');
    }
}