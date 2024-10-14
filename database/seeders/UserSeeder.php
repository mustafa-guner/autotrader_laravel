<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 regular users
        User::factory()->count(10)->create();

        // Create 1 virtual account
        User::factory()->virtualAccount()->create();
    }
}
