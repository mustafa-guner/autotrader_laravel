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
        $bank = [
            'name' => 'Garanti Bank',
            'description' => 'Garanti Bank description',
            'logo' => 'https://www.garantibbva.com.tr/content/experience-fragments/public-website/tr/site/header/master/_jcr_content/root/header/headerdesktop/image.coreimg.svg/1699885476212/logo.svg',
        ];
        Bank::create($bank);
    }
}
