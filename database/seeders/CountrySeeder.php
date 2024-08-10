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
            DB::table('countries')->updateOrInsert(
                ['iso_code' => $country['cca2']],
                [
                    'name' => $country['name']['common'],
                    'iso_code' => $country['cca2'],
                    'flag' => $country['flags']['png'],
                    'calling_code' => $country['idd']['root'] . (isset($country['idd']['suffixes']) ? implode(', ', $country['idd']['suffixes']) : '')
                ]
            );
        }


    }
}
