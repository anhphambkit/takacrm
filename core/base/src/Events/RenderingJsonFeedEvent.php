<?php

namespace Core\Base\Events;

use Illuminate\Queue\SerializesModels;

class RenderingJsonFeedEvent extends Event
{
    use SerializesModels;

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     * @author Trinh Le
     */
    public function broadcastOn()
    {
        return [];
    }
}
