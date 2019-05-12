<?php
namespace Core\User\Repositories\Interfaces;

use Core\Master\Repositories\Interfaces\RepositoryInterface;

interface UserInterface extends RepositoryInterface
{

    /**
     * @return mixed
     * @author TrinhLe
     */
    public function getDataSiteMap();

    /**
     * Get unique username from email
     *
     * @param $email
     * @return string
     * @author TrinhLe
     */
    public function getUniqueUsernameFromEmail($email);

    /**
     * @return mixed
     */
    public function getAllUsers();
}
