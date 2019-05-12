<?php 
namespace Core\User\Services\Excute;
use Core\User\Services\Interfaces\UpdateProfileImageServiceInterface;
use Core\Master\Services\CoreServiceAbstract;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\Media\Services\FileService;
use Core\User\Services\CropAvatar;
use Exception;
use File;
use Illuminate\Http\Request;
use Storage;

class UpdateProfileImageServiceExcute extends CoreServiceAbstract implements UpdateProfileImageServiceInterface
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
        if (!$request->hasFile('avatar_file')) {
            return new Exception(trans('core-user::users.error_update_profile_image'));
        }

        $user          = $this->userRepository->findById($request->input('user_id'));
        $file          = $request->file('avatar_file');
        $fileName      = $file->getClientOriginalName();
        $fileExtension = $file->getClientOriginalExtension();

        $avatar = [
            'path'     => basename(public_path()) . DIRECTORY_SEPARATOR . config('core-user.acl.avatar.container_dir') . DIRECTORY_SEPARATOR . $user->username . '/full-' . str_slug(basename($fileName, $fileExtension)) . '-' . time() . '.' . $fileExtension,
            'realPath' => basename(public_path()) . DIRECTORY_SEPARATOR . config('core-user.acl.avatar.container_dir') . DIRECTORY_SEPARATOR . $user->username . '/thumb-' . str_slug(basename($fileName, $fileExtension)) . '-' . time() . '.' . $fileExtension,
            'ext'      => $fileExtension,
            'mime'     => $request->file('avatar_file')->getMimeType(),
            'name'     => $fileName,
            'user'     => $user->id,
            'size'     => $request->file('avatar_file')->getSize(),
        ];

        File::deleteDirectory(storage_path('app/public') . DIRECTORY_SEPARATOR . config('core-user.acl.avatar.container_dir') . DIRECTORY_SEPARATOR . $user->username);
        Storage::put($avatar['path'], file_get_contents($request->file('avatar_file')->getRealPath()), 'public');

        $crop = new CropAvatar($request->input('avatar_src'), $request->input('avatar_data'), $avatar);
        $user->profile_image = "/storage" . $crop->getResult();

        $this->userRepository->createOrUpdate($user);

        return "/storage" . $crop->getResult();
    }
}