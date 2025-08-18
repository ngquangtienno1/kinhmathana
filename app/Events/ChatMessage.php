<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatMessage implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $from_id;
    public $from_name;
    public $to_id;
    public $message;
    public $from_avatar;
    public $attachment;
    public $type;

    public function __construct($from_id, $from_name, $to_id, $message, $from_avatar = null, $attachment = null, $type = 'text')
    {
        $this->from_id = $from_id;
        $this->from_name = $from_name;
        $this->to_id = $to_id;
        $this->message = $message;
        $this->from_avatar = $from_avatar;
        $this->attachment = $attachment;
        $this->type = $type;
    }

    public function broadcastOn()
    {
        return ['chat-user-' . $this->to_id];
    }

    public function broadcastAs()
    {
        return 'chat-message';
    }

    public function broadcastWith()
    {
        return [
            'from_id' => $this->from_id,
            'from_name' => $this->from_name,
            'to_id' => $this->to_id,
            'message' => $this->message,
            'avatar' => $this->from_avatar,
            'attachment' => $this->attachment,
            'type' => $this->type,
            'user' => [
                'id' => $this->from_id,
                'name' => $this->from_name,
                'avatar' => $this->from_avatar,
            ]
        ];
    }
}
