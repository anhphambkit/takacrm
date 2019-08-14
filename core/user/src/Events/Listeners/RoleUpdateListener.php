<?php

namespace Core\User\Events\Listeners;

use Core\User\Events\RoleUpdateEvent;
use Core\User\Repositories\Interfaces\UserInterface;
use Core\User\Models\Role;
use Auth;

class RoleUpdateListener
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
     * @param RoleUpdateEvent $event
     * @throws \Exception
     */
    public function handle(RoleUpdateEvent $event)
    {
        $permissions = $event->role->permissions;

        $this->updatePermission($event->role, $permissions);

        $subDomain = function_exists('get_sub_domain') ? get_sub_domain() : null;

        cache()->forget(md5("{$subDomain}_cache-dashboard-menu-" . Auth::user()->getKey()));
    }


    /**
     * Update permission for user and child role
     * @author TrinhLe
     * @param Role $role 
     * @param array $permissions 
     */
    protected function updatePermission(Role $role, array $permissions)
    {
        foreach ($role->users()->get() as $user) {
            $permissions['superuser'] = $user->super_user;
            $permissions['manage_supers'] = $user->manage_supers;

            $this->userRepository->update([
                'id' => $user->id,
            ], [
                'permissions' => json_encode($permissions),
            ]);
        }

        foreach ($role->children()->get() as $childRole) {
            $permissions            = merge_permission_parent($role, $childRole->permissions);
            $childRole->permissions = $permissions;
            $childRole->save();
            $this->updatePermission($childRole, $permissions);
        }
    }
}