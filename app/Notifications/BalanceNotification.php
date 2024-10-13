<?php

namespace App\Notifications;

use App\Constants\NotificationTypeConstants;
use App\Models\NotificationUser;
use App\Models\UserBalance;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class BalanceNotification extends Notification
{
    public UserBalance $userBalance;
    public string $message;

    public function __construct(UserBalance $userBalance)
    {
        $this->userBalance = $userBalance;
        $this->message = trans('balance.default_notification_message', [
            'amount' => $this->userBalance->balance,
            'currency' => $this->userBalance->currency
        ]);
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        Log::info('Sending notification email to user: ' . $notifiable->id);
        return (new MailMessage)
            ->subject('Balance Notification')
            ->line($notifiable->full_name . ',')
            ->line($this->message)
            ->action('See your balance', config('app.client_url'));
    }

    public function toArray(object $notifiable): array
    {
        return [
            'user_id' => $notifiable->id,
            'content' => $this->message,
        ];
    }
}
