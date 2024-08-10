<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'title' => 'Welcome to the platform',
                'content' => 'Welcome to the platform. We are glad to have you here.',
                'type' => 'info',
                'thumbnail' => 'https://via.placeholder.com/150',
            ],
            [
                'title' => 'Payment Successful!',
                'content' => 'Your payment was successful. Thank you for your patronage.',
                'type' => 'success',
                'thumbnail' => 'https://via.placeholder.com/150',
            ],
            [
                'title' => 'Payment Failed!',
                'content' => 'Your payment failed. Please try again.',
                'type' => 'error',
                'thumbnail' => 'https://via.placeholder.com/150',
            ],
            [
                'title' => 'Account Suspended!',
                'content' => 'Your account has been suspended. Please contact support.',
                'type' => 'warning',
                'thumbnail' => 'https://via.placeholder.com/150',
            ]
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }
    }
}
