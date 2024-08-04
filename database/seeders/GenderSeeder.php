<?php

namespace Database\Seeders;

use App\Models\Gender;

use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $genders = [
            ['name' => 'Female'],
            ['name' => 'Male'],
            ['name' => 'Other'],
        ];

        foreach ($genders as $gender) {
            Gender::create($gender);
        }
    }
}
