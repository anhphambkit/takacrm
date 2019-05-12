<?php
namespace Core\User\Controllers\Web;
use Core\Base\Controllers\Web\BasePublicController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Core\Base\Responses\BaseHttpResponse;
use Illuminate\Http\Request;

class ForgotPasswordController extends BasePublicController{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * @var BaseHttpResponse
     */
    protected $response;

    /**
     * Create a new controller instance.
     *
     * @param BaseHttpResponse $response
     */
    public function __construct(BaseHttpResponse $response)
    {
        $this->middleware('guest');
        $this->response = $response;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function showLinkRequestForm()
    {
        return view('core-user::auth.forgot-password');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param Request $request
     * @param  string $response
     * @return BaseHttpResponse
     * @author TrinhLe
     */
    protected function sendResetLinkResponse($response)
    {
        return $this->response->setMessage(trans($response));
    }
}