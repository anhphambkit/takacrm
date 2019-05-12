<?php

namespace Core\User;

use Core\User\Models\User;
use Core\User\Repositories\Interfaces\ActivationRepositories as ActivationInterface; 
use Core\User\Repositories\Interfaces\RoleInterface;
use Core\User\Repositories\Interfaces\UserInterface;
use InvalidArgumentException;

class AclManager
{
    /**
     * The User repository.
     *
     * @var \Core\User\Repositories\Interfaces\UserInterface
     */
    protected $users;

    /**
     * The Role repository.
     *
     * @var \Core\User\Repositories\Interfaces\RoleInterface
     */
    protected $roles;

    /**
     * The Activations repository.
     *
     * @var \Core\User\Repositories\Interfaces\ActivationInterface
     */
    protected $activations;

    /**
     * AclManager constructor.
     * @param UserInterface $users
     * @param RoleInterface $roles
     * @param ActivationInterface $activations
     */
    public function __construct( UserInterface $users, RoleInterface $roles, ActivationInterface $activations )
    {
        $this->users       = $users;
        $this->roles       = $roles;
        $this->activations = $activations;
    }

    /**
     * Activates the given user.
     *
     * @param  mixed $user
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function activate($user)
    {
        if (!$user instanceof User) {
            throw new InvalidArgumentException('No valid user was provided.');
        }

        event('acl.activating', $user);

        $activations = $this->getActivationRepository();

        $activation = $activations->createUser($user);

        event('acl.activated', [$user, $activation]);

        return $activations->complete($user, $activation->getCode());
    }

    /**
     * @return UserInterface
     */
    public function getUserRepository()
    {
        return $this->users;
    }

    /**
     * Returns the role repository.
     *
     * @return \Core\User\Repositories\Interfaces\RoleInterface
     */
    public function getRoleRepository()
    {
        return $this->roles;
    }

    /**
     * Sets the role repository.
     *
     * @param  \Core\User\Repositories\Interfaces\RoleInterface $roles
     * @return void
     */
    public function setRoleRepository(RoleInterface $roles)
    {
        $this->roles = $roles;
    }

    /**
     * Returns the activations repository.
     *
     * @return \Core\User\Repositories\Interfaces\ActivationInterface
     */
    public function getActivationRepository()
    {
        return $this->activations;
    }

    /**
     * Sets the activations repository.
     *
     * @param  \Core\User\Repositories\Interfaces\ActivationInterface $activations
     * @return void
     */
    public function setActivationRepository(ActivationInterface $activations)
    {
        $this->activations = $activations;
    }
}
