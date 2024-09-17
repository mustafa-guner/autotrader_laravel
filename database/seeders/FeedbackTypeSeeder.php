<?php

namespace Database\Seeders;

use App\Models\FeedbackType;
use Illuminate\Database\Seeder;

class FeedbackTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $feedback_types = [
            ['name' => 'Bug','created_at' => now(),'updated_at' => now()],
            ['name' => 'Suggestion','created_at' => now(),'updated_at' => now()],
            ['name' => 'Complaint','created_at' => now(),'updated_at' => now()],
            ['name' => 'Feature','created_at' => now(),'updated_at' => now()],
            ['name' => 'Other','created_at' => now(),'updated_at' => now()],
        ];

        FeedbackType::insert($feedback_types);
    }
}
