<?php

namespace Core\User\Events\Listeners;

use Core\User\Events\RoleAssignmentEvent;
use Core\User\Repositories\Interfaces\UserInterface;
use Auth;
class RoleAssignmentListener
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * RoleAssignmentListener constructor.
     * @author TrinhLe
     * @param UserInterface $userRepository
     */
    public function __construct(UserInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param RoleAssignmentEvent $event
     * @throws \Exception
     */
    public function handle(RoleAssignmentEvent $event)
    {
        $permissions = $event->role->permissions;
        $permissions['superuser'] = $event->user->super_user;
        $permissions['manage_supers'] = $event->user->manage_supers;

        $this->userRepository->update([
            'id' => $event->user->id,
        ], [
            'permissions' => json_encode($permissions),
        ]);

        $subDomain = function_exists('get_sub_domain') ? get_sub_domain() : null;
        cache()->forget(md5("{$subDomain}_cache-dashboard-menu-" . Auth::user()->getKey()));
    }
}
