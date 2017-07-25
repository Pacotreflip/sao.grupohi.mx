<?php

namespace Ghi\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewEmail extends Event implements ShouldBroadcast
{
    use SerializesModels;


    public $email;
    public $db;

    /**
     * NewEmail constructor.
     * @param $id
     * @param $title
     * @param $message
     * @param $idusuario
     */
    public function __construct($email,$db)
    {
        $this->email = $email->toArray();
        $this->db=$db;
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
