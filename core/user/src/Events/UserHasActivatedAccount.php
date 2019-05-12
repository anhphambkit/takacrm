<?php

namespace Core\User\Events;

class UserHasActivatedAccount
{
	/**
	 * @var \Core\User\Models\User
	 */
    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}
