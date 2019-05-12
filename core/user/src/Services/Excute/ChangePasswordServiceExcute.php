<?php 
namespace Core\User\Services\Excute;
use Core\User\Services\Interfaces\ChangePasswordServiceInterface;
use Core\Master\Services\CoreServiceAbstract;
use Core\User\Repositories\Interfaces\UserInterface;
use Exception;
use Illuminate\Http\Request;
use Auth;
use Hash;
class ChangePasswordServiceExcute extends CoreServiceAbstract implements ChangePasswordServiceInterface
{
	/**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * ResetPasswordService constructor.
     * @param UserInterface $userRepository
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return bool|\Exception
     * @author TrinhLe
     */
    public function execute(Request $request)
    {
        $currentUser = Auth::user();

        if (!$currentUser->isSuperUser()) {
            if (!Hash::check($request->input('old_password'), Auth::user()->getAuthPassword())) {
                return new Exception(trans('core-user::users.current_password_not_valid'));
            }
        }

        $userId = $request->input('id', Auth::user()->getKey());
        $user   = $this->userRepository->findById($userId);
        
        $this->userRepository->update(['id' => $user->id], [
            'password' => Hash::make($request->input('password')),
        ]);

        if($userId === Auth::user()->getKey())
            Auth::logoutOtherDevices($request->input('password'));

        return $user;
    }
}