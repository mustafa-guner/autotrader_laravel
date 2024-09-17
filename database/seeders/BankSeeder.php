<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banks = [
            [
                'name' => 'Garanti Bank',
                'description' => 'Garanti Bank description',
                'swift_code' => 'TGBATRIS',
            ],
            [
                'name' => 'Ziraat Bank',
                'description' => 'Ziraat Bank description',
                'swift_code' => 'TCZBTR2A',
            ],
            [
                'name' => 'Akbank',
                'description' => 'Akbank description',
                'swift_code' => 'AKBKTRIS',
            ],
            [
                'name' => 'Yapı Kredi Bank',
                'description' => 'Yapı Kredi Bank description',
                'swift_code' => 'YAPITRIS',
            ],
            [
                'name' => 'İş Bank',
                'description' => 'İş Bank description',
                'swift_code' => 'ISBKTRIS',
            ],
        ];

        Bank::insert($banks);
    }
}
