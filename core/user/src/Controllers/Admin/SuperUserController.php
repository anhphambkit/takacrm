<?php
namespace Core\User\Controllers\Admin;
use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\DataTables\SuperUserDataTable;
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\UserInterface;
use AssetManager;
use AssetPipeline;
use Illuminate\Http\Request;

class SuperUserController extends BaseAdminController{
    
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
    public function index(SuperUserDataTable $dataTable)
    {
        return $dataTable->render('core-user::admin.user.super-index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @author TrinhLe
     */
    public function postCreate(Request $request)
    {
        try {
            $user = $this->userRepository->getFirstBy(['email' => $request->input('email')]);
            if (!empty($user)) {
                $user->updatePermission('superuser', true);
                $user->super_user = 1;
                $this->userRepository->createOrUpdate($user);
                return redirect()->route('admin.super-user.index')->with('success_msg', trans('core-base::system.supper_granted'));
            }
            return redirect()->route('admin.super-user.index')->with('error_msg', trans('core-base::system.cant_find_user_with_email'))->withInput();
        } catch (Exception $e) {
            return redirect()->route('admin.super-user.index')->with('error_msg', trans('core-base::system.cant_find_user_with_email'))->withInput();
        }
    }
}