<?php

namespace Database\Seeders;

use GuzzleHttp\Client;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client();
        $response = $client->get(config('services.countries_api_v3.url'));
        $countries = json_decode($response->getBody(), true);

        foreach ($countries as $country) {
            if (isset($country['idd']['root'])) {
                DB::table('countries')->updateOrInsert(
                    ['iso_code' => $country['cca2']],
                    [
                        'name' => $country['name']['common'],
                        'flag' => $country['flags']['png'],
                        'calling_code' => $country['idd']['root'],
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
