<?php

namespace Database\Seeders;

use App\Models\TransactionType;
use Illuminate\Database\Seeder;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactionTypes = [
            ['name' => 'Purchase'],
            ['name' => 'Sale'],
            ['name' => 'Withdrawal'],
            ['name' => 'Deposit'],
            ['name' => 'Transfer']
        ];

        foreach ($transactionTypes as $transactionType) {
            TransactionType::create($transactionType);
        }
    }
}
