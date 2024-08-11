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
            ['definition' => 'Purchase'],
            ['definition' => 'Sale'],
            ['definition' => 'Withdrawal'],
            ['definition' => 'Deposit'],
            ['definition' => 'Transfer']
        ];

        foreach ($transactionTypes as $transactionType) {
            TransactionType::create($transactionType);
        }
    }
}
