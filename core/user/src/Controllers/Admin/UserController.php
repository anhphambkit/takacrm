<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\UserDataTable;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\User\Requests\CreateUserRequest;
use Core\User\Requests\UpdateProfileRequest;
use Core\User\Requests\UpdatePasswordRequest;
use Core\User\Requests\ChangeProfileImageRequest;
use Core\User\Services\Interfaces\ChangePasswordServiceInterface;
use Core\User\Services\Interfaces\CreateUserServiceInterface;
use Core\User\Services\Interfaces\UpdateProfileImageServiceInterface;
use AssetManager;
use AssetPipeline;
use Request;

class UserController extends BaseAdminController{
    
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * @var RoleInterface
     */
    protected $roleRepository;

    /**
     * UserController constructor.
     * @param RoleInterface $roleRepository
     */
    public function __construct( RoleInterface $roleRepository, UserInterface $userRepository ) 
    {
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    /**
     * Show page dashboard user
     * @author TrinhLe
     * @return View
     */
    public function index(UserDataTable $dataTable)
    {
        AssetPipeline::requireCss('editable-css');
        AssetPipeline::requireJs('editable-js');

        $roles = $this->roleRepository->pluck('name', 'id');
        return $dataTable->render('core-user::admin.user.index', compact('roles'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author TrinhLe
     */
    public function getCreate()
    {
        page_title()->setTitle('Create User');

        $roles = $this->roleRepository->pluck('name', 'id');

        return view('core-user::admin.user.create', compact('roles'));
    }

    /**
     * @param CreateUserRequest $request
     * @param CreateUserService $service
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(CreateUserRequest $request, CreateUserServiceInterface $service)
    {
        $user = $service->execute($request);

        if ($request->input('submit') === 'save') {
            return redirect()->route('admin.user.index')->with('success_msg', trans('core-base::notices.create_success_message'));
        }
        return redirect()->route('admin.user.profile', $user->id)->with('success_msg', trans('core-base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View| \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function getUserProfile($id)
    {
        page_title()->setTitle('User profile # ' . $id);
        $this->addAssets();

        try {
            $user = $this->userRepository->findById($id);

        } catch (Exception $e) {
            return redirect()->back()
                ->with('error_msg', trans('core-user::users.not_found'));
        }

        if(!$user)
            return redirect()->route('admin.user.index')
                ->with('error_msg', trans('core-user::users.not_found'));

        $roles = $this->roleRepository->pluck('name', 'id');

        return view('core-user::admin.user.profile', compact('roles'))
            ->with('user', $user);
    }

    /**
     * @param $id
     * @param UpdateProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postUpdateProfile($id, UpdateProfileRequest $request)
    {
        $user = $this->userRepository->findById($id);

        /**
         * @var User $currentUser
         */
        $currentUser = auth()->user();
       
        if (($currentUser->hasPermission('user.update-profile') && $currentUser->getKey() === $user->id) || $currentUser->isSuperUser()) {
            if ($user->email !== $request->input('email')) {
                $users = $this->userRepository->count(['email' => $request->input('email')]);
                if (!$users) {
                    $user->email = $request->input('email');
                } else {
                    return redirect()->route('admin.user.profile', [$id])
                        ->with('error_msg', trans('core-user::users.email_exist'))
                        ->withInput();
                }
            }

            if ($user->username !== $request->input('username')) {
                $users = $this->userRepository->count(['username' => $request->input('username')]);
                if (!$users) {
                    $user->username = $request->input('username');
                } else {
                    return redirect()->route('admin.user.profile', [$id])
                        ->with('error_msg', trans('core-user::users.username_exist'))
                        ->withInput();
                }
            }
        }
        
        $user->fill($request->input());
        $user->completed_profile = 1;
        $this->userRepository->createOrUpdate($user);
        $user->roles()->sync([$request->role_id]);

        do_action(USER_ACTION_AFTER_UPDATE_PROFILE, USER_MODULE_SCREEN_NAME, $request, $user);

        return redirect()->route('admin.user.profile', [$id])
            ->with('success_msg', trans('core-user::users.update_profile_success'));
    }

    /**
     * @param ChangeProfileImageRequest $request
     * @param UpdateProfileImageService $service
     * @return array
     * @author TrinhLe
     */
    public function postModifyProfileImage(ChangeProfileImageRequest $request, UpdateProfileImageServiceInterface $service)
    {
        try {

            $result = $service->execute($request);

            if ($result instanceof  Exception) {
                return [
                    'error' => false,
                    'message' => $result->getMessage(),
                ];
            }

            return [
                'error' => false,
                'message' => trans('core-user::users.update_avatar_success'),
                'result' => $result,
            ];

        } catch (Exception $ex) {
            return  [
                'error' => true,
                'message' => $ex->getMessage(),
            ];
        }
    }

    /**
     * @param $id
     * @param UpdatePasswordRequest $request
     * @param ChangePasswordService $service
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postChangePassword($id, UpdatePasswordRequest $request, ChangePasswordServiceInterface $service)
    {
        $request->merge(['id' => $id]);
        
        $result = $service->execute($request);

        if ($result instanceof Exception) {
            return redirect()->back()
                ->with('error_msg', $result->getMessage());
        }

        return redirect()->route('admin.user.profile', [$id])
            ->with('success_msg', trans('core-user::users.password_update_success'));
    }


    /**
     * @param $id
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     * @author Sang Nguyen
     */
    public function getDelete($id, Request $request)
    {
        if (auth()->id() == $id) {
            return [
                'error' => true,
                'message' => trans('core-user::users.delete_user_logged_in'),
            ];
        }

        try {
            $user = $this->userRepository->findById($id);
            $this->userRepository->delete($user);
            return [
                'error' => false,
                'message' => trans('core-user::users.deleted'),
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'message' => trans('core-user::users.cannot_delete'),
            ];
        }
    }

    /**
     * Add frontend plugins for layout
     * @author TrinhLe
     */
    private function addAssets()
    {
        AssetManager::addAsset('role-js', 'backend/core/user/assets/js/role.js');
        AssetManager::addAsset('cropper-js', '//cdnjs.cloudflare.com/ajax/libs/cropper/0.7.9/cropper.min.js');
        AssetManager::addAsset('bootstrap-pwstrength-js', 'backend/core/user/packages/pwstrength-bootstrap/pwstrength-bootstrap.min.js');
        AssetManager::addAsset('profile-js', 'backend/core/user/assets/js/profile.js');
        AssetManager::addAsset('cropper-css', 'backend/core/user/assets/css/cropper.css');
        AssetManager::addAsset('profile-css', 'backend/core/user/assets/css/profile.css');

        AssetPipeline::requireCss('jquery-tree-css');
        AssetPipeline::requireCss('cropper-css');
        AssetPipeline::requireCss('profile-css');
        AssetPipeline::requireJs('jquery-tree-js');
        AssetPipeline::requireJs('role-js');
        AssetPipeline::requireJs('cropper-js');
        AssetPipeline::requireJs('bootstrap-pwstrength-js');
        AssetPipeline::requireJs('profile-js');
    }
}