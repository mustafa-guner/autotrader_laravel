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
                'logo' => 'https://www.garantibbva.com.tr/content/experience-fragments/public-website/tr/site/header/master/_jcr_content/root/header/headerdesktop/image.coreimg.svg/1699885476212/logo.svg',
            ],
            [
                'name' => 'Ziraat Bank',
                'description' => 'Ziraat Bank description',
                'logo' => 'https://www.ziraatbank.com.tr/Themes/ZiraatBank/assets/images/logo.svg',
            ],
            [
                'name' => 'Akbank',
                'description' => 'Akbank description',
                'logo' => 'https://www.akbank.com/Themes/Akbank/assets/images/logo.svg',
            ],
            [
                'name' => 'Yapı Kredi Bank',
                'description' => 'Yapı Kredi Bank description',
                'logo' => 'https://www.yapikredi.com.tr/Themes/YapiKredi/assets/images/logo.svg',
            ],
            [
                'name' => 'İş Bank',
                'description' => 'İş Bank description',
                'logo' => 'https://www.isbank.com.tr/Themes/Isbank/assets/images/logo.svg',
            ],
        ];

        foreach ($banks as $bank) {
            Bank::create($bank);
        }
    }
}
