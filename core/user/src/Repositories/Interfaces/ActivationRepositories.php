<?php
namespace Core\User\Repositories\Interfaces;
use Core\Master\Repositories\Interfaces\RepositoryInterface;
use Core\User\Models\User;

interface ActivationRepositories extends RepositoryInterface
{
    /**
     * Create a new activation record and code.
     *
     * @param  \Core\User\Models\User $user
     * @return \Core\User\Models\Activation
     */
    public function createUser(User $user);

    /**
     * Checks if a valid activation for the given user exists.
     *
     * @param  \Core\User\Models\User $user
     * @param  string $code
     * @return \Core\User\Models\Activation|bool
     */
    public function exists(User $user, $code = null);

    /**
     * Completes the activation for the given user.
     *
     * @param  \Core\User\Models\User $user
     * @param  string $code
     * @return bool
     */
    public function complete(User $user, $code);

    /**
     * Checks if a valid activation has been completed.
     *
     * @param  \Core\User\Models\User $user
     * @return \Core\User\Models\Activation|bool
     */
    public function completed(User $user);

    /**
     * Remove an existing activation (deactivate).
     *
     * @param  \Core\User\Models\User $user
     * @return bool|null
     */
    public function remove(User $user);

    /**
     * Remove expired activation codes.
     *
     * @return int
     */
    public function removeExpired();
}