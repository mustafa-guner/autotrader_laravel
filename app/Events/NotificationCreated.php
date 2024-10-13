<?php

namespace App\Events;

use App\Models\NotificationUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public NotificationUser $notification;

    public function __construct(NotificationUser $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('user.' . $this->notification->user_id);
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification->id,
            'message' => $this->notification->message,
            'is_read' => $this->notification->is_read,
        ];
    }
}
