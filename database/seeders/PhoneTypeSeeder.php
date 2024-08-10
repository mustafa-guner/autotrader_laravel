<?php

namespace Database\Seeders;

use App\Models\PhoneType;
use Illuminate\Database\Seeder;

class PhoneTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $phoneTypes = [
            ['definition' => 'Primary Phone'],
            ['definition' => 'Secondary Phone'],
        ];

        foreach ($phoneTypes as $phoneType) {
            PhoneType::create($phoneType);
        }
    }
}
