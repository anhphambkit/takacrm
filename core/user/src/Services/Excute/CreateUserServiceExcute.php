<?php 
namespace Core\User\Services\Excute;
use Core\User\Services\Interfaces\CreateUserServiceInterface;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\Master\Services\CoreServiceAbstract;
use Core\User\Events\RoleAssignmentEvent;
use Illuminate\Http\Request;
use Core\User\Models\User;
use Illuminate\Support\Facades\Hash;
use AclManager;

class CreateUserServiceExcute extends CoreServiceAbstract implements CreateUserServiceInterface
{
	/**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;
  
    /**
     * CreateUserService constructor.
     * @param UserInterface $userRepository
     * @param RoleInterface $roleRepository
     */
    public function __construct(UserInterface $userRepository, RoleInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @param Request $request
     * @author TrinhLe
     * @return User|false|\Illuminate\Database\Eloquent\Model|mixed
     */
    public function execute(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->userRepository->createOrUpdate(array_merge($request->input(), [
            'profile_image' => config('core-user.acl.avatar.default'),
        ]));

        if ($request->has('username') && $request->has('password')) {
            $this->userRepository->update(['id' => $user->id], [
                'username' => $request->input('username'),
                'password' => Hash::make($request->input('password')),
            ]);

            if (AclManager::activate($user) && $request->has('role_id')) {
                $role = $this->roleRepository->getFirstBy([
                    'id' => $request->input('role_id'),
                ]);

                if (!empty($role)) {
                    $role->users()->attach($user->id);

                    event(new RoleAssignmentEvent($role, $user));
                }
            }
        }

        return $user;
    }
}