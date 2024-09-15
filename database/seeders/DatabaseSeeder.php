<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CountrySeeder::class,
            TransactionTypeSeeder::class,
            TransactionStatusSeeder::class,
            GenderSeeder::class,
            BankSeeder::class,
            PhoneTypeSeeder::class,
            BankSeeder::class,
            UserSeeder::class,
            BankAccountSeeder::class,
            AnnouncementSeeder::class,
            NotificationSeeder::class,
            NotificationUserSeeder::class
        ]);
    }
}
