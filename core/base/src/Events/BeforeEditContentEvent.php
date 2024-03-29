<?php

namespace Core\Base\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class BeforeEditContentEvent extends Event
{
    use SerializesModels;

    /**
     * @var string
     */
    public $screen;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var \Eloquent|false
     */
    public $data;

    /**
     * CreatedContentEvent constructor.
     * @param string $screen
     * @param Request $request
     * @param \Eloquent|false $data
     */
    public function __construct($screen, $request, $data)
    {
        $this->screen  = $screen;
        $this->request = $request;
        $this->data    = $data;
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
