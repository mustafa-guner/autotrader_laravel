<?php

namespace App\Notifications;

use App\Models\UserBalance;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BalanceNotification extends Notification
{
    use Queueable;

    public UserBalance $userBalance;

    /**
     * Create a new notification instance.
     */
    public function __construct(UserBalance $userBalance)
    {
        $this->userBalance = $userBalance;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Balance Notification')
            ->line($notifiable->firstname . ',')
            ->line(trans('balance.default_notification_message', ['amount' => $this->userBalance->balance, 'currency' => $this->userBalance->currency]))
            ->action('Check your balance', config('app.client_url'));
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
