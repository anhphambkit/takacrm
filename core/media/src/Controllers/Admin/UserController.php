<?php

namespace Core\Media\Controllers\Admin;

use Core\Base\Controllers\Admin\BaseAdminController;
use Illuminate\Validation\ValidationException;
use Core\User\Repositories\Interfaces\UserInterface;
use BMedia;

class UserController extends BaseAdminController
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * FolderController constructor.
     * @param UserInterface $userRepository
     * @author TrinhLe
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @author TrinhLe
     */
    public function getList()
    {
        $users = $this->userRepository->getListUsers();

        return BMedia::responseSuccess($users);
    }
}
