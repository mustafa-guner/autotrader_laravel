<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use App\Models\NotificationUser;
use App\Models\User;
use Illuminate\Database\Seeder;

class NotificationUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notification_users = [
            [
                'user_id' => User::factory()->create()->id,
                'message' => 'This is a success notification',
                'is_read' => false,
            ],
            [
                'user_id' => User::factory()->create()->id,
                'message' => 'This is an error notification',
                'is_read' => false,
            ],
            [
                'user_id' => User::factory()->create()->id,
                'message' => 'This is a warning notification',
                'is_read' => false,
            ]
        ];

        foreach ($notification_users as $notification_user) {
            NotificationUser::create($notification_user);
        }
    }
}
