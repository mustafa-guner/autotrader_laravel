<?php

namespace Database\Seeders;

use App\Models\UserBalance;
use Illuminate\Database\Seeder;

class UserBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserBalance::factory()
            ->count(2)
            ->create();
    }
}
