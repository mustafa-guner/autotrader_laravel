<?php

namespace Database\Seeders;

use App\Models\NotificationType;
use Illuminate\Database\Seeder;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'title' => 'Success',
            ],
            [
                'title' => 'Error',
            ],
            [
                'title' => 'Warning',
            ],
            [
                'title' => 'Info',
            ]
        ];

        foreach ($notifications as $notification) {
            NotificationType::create($notification);
        }
    }
}
