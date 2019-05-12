<?php

namespace Core\User\Events;

use Illuminate\Queue\SerializesModels;
use Core\User\Models\Role;
use Event;

class RoleUpdateEvent extends Event
{
    use SerializesModels;

    /**
     * @var mixed
     */
    public $role;

    /**
     * RoleUpdateEvent constructor.
     * @param Role $role
     * @author TrinhLe
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     * @author TrinhLe
     */
    public function broadcastOn()
    {
        return [];
    }
}
