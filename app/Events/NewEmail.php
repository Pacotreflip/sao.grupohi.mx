<?php

namespace Ghi\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewEmail extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $id;
    public $title;
    public $message;
    public $idusuario;

    /**
     * NewEmail constructor.
     * @param $id
     * @param $title
     * @param $message
     * @param $idusuario
     */
    public function __construct($id, $title, $message, $idusuario)
    {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
        $this->idusuario = $idusuario;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['emails-channel'];
    }
}
