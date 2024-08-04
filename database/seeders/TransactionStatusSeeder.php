<?php

namespace Database\Seeders;

use App\Models\TransactionStatus;
use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $transactionStatuses = [
            ['definition' => 'Pending'],
            ['definition' => 'Approved'],
            ['definition' => 'Rejected'],
            ['definition' => 'Cancelled']
        ];

        foreach ($transactionStatuses as $transactionStatus) {
            TransactionStatus::create($transactionStatus);
        }
    }
}
