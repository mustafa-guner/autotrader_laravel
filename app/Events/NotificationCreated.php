<?php

namespace App\Events;

use App\Models\NotificationUser;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public NotificationUser $notification;
    public array $data;

    public function __construct(NotificationUser $notification, array $data = [])
    {
        $this->notification = $notification;
        $this->data = $data;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('notifications.' . $this->notification->user_id);
    }

    public function broadcastWith(): array
    {
        $notification = [
            'id' => $this->notification->id,
            'message' => $this->notification->message,
            'is_read' => $this->notification->is_read,
        ];

        if ($this->data) {
            $notification = array_merge($notification, $this->data);
        }

        return $notification;
    }
}
