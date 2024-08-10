<?php

namespace Database\Seeders;

use App\Models\UserBalance;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userBalance = [
            'user_id' => UserFactory::make()->id,
            'balance' => 3000,
            'currency' => 'USD',
        ];

        UserBalance::create($userBalance);
    }
}
