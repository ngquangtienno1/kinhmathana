<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message_id;
    public $from_id;
    public $to_id;

    public function __construct($message_id, $from_id, $to_id)
    {
        $this->message_id = $message_id;
        $this->from_id = $from_id;
        $this->to_id = $to_id;
    }

    public function broadcastOn()
    {
        return [
            'chat-user-' . $this->to_id,
            'chat-user-' . $this->from_id
        ];
    }

    public function broadcastAs()
    {
        return 'message-deleted';
    }

    public function broadcastWith()
    {
        return [
            'message_id' => $this->message_id,
            'from_id' => $this->from_id,
            'to_id' => $this->to_id
        ];
    }
}
