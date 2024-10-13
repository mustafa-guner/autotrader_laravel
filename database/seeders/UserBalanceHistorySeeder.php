<?php

namespace Database\Seeders;

use App\Models\UserBalanceHistory;
use Illuminate\Database\Seeder;

class UserBalanceHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserBalanceHistory::factory()
            ->count(10)
            ->create();
    }
}
