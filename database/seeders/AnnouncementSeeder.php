<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcements = [
            [
                'title' => 'Welcome to our platform!',
                'thumbnail' => 'https://via.placeholder.com/150',
                'content' => 'We are excited to have you here. We hope you enjoy your stay.',
                'created_at' => now(),
                'published_at' => now(),
                'created_by' => User::factory()->create()->id,
                'published_by' => User::factory()->create()->id,
                'updated_at' => now(),
            ],
            [
                'title' => 'New feature alert!',
                'thumbnail' => 'https://via.placeholder.com/150',
                'content' => 'We have added a new feature that allows you to track your progress.',
                'created_at' => now(),
                'published_at' => now(),
                'updated_at' => now(),
                'created_by' => User::factory()->create()->id,
                'published_by' => User::factory()->create()->id,
            ],
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }
    }
}
