<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CommentCreated implements ShouldBroadcast //se implementa shouldbroadcast para que se ejecute broadcastOn automaticamente.
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $comment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($comment)
    {
        $this->dontBroadcastToCurrentUser();
        $this->comment = $comment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("statuses.{$this->comment->status_id}.comments");
    }
}
