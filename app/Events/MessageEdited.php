<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageEdited implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message_id;
    public $from_id;
    public $to_id;
    public $new_message;

    public function __construct($message_id, $from_id, $to_id, $new_message)
    {
        $this->message_id = $message_id;
        $this->from_id = $from_id;
        $this->to_id = $to_id;
        $this->new_message = $new_message;
    }

    public function broadcastOn()
    {
        return ['chat-user-' . $this->to_id];
    }

    public function broadcastAs()
    {
        return 'message-edited';
    }

    public function broadcastWith()
    {
        return [
            'message_id' => $this->message_id,
            'from_id' => $this->from_id,
            'to_id' => $this->to_id,
            'new_message' => $this->new_message
        ];
    }
}
