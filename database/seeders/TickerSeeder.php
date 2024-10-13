<?php

namespace Database\Seeders;

use App\Models\Ticker;
use GuzzleHttp\Client;
use Illuminate\Database\Seeder;

class TickerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Client(['verify' => false]);
        //get the list first
        $url = config('services.polygon.tickers.list_url_v3') . config('services.polygon.api_key');
        $response = $client->get($url);
        $tickers = json_decode($response->getBody(), true)['results'];


        foreach ($tickers as $ticker) {
            $detailUrl = "https://api.polygon.io/v3/reference/tickers/{$ticker['ticker']}?apiKey=" . config('services.polygon.api_key');
            $detailResponse = $client->get($detailUrl);
            $details = json_decode($detailResponse->getBody(), true)['results'];

            Ticker::firstOrCreate(
                ['ticker' => $ticker['ticker']],
                [
                    'name' => $ticker['name'],
                    'market' => $ticker['market'],
                    'locale' => $ticker['locale'],
                    'primary_exchange' => $ticker['primary_exchange'] ?? null,
                    'type' => $ticker['type'],
                    'active' => $ticker['active'],
                    'currency_name' => $ticker['currency_name'],
                    'cik' => $details['cik'] ?? null,
                    'composite_figi' => $ticker['composite_figi'] ?? null,
                    'share_class_figi' => $ticker['share_class_figi'] ?? null,
                    'market_cap' => $details['market_cap'] ?? null,
                    'phone_number' => $details['phone_number'] ?? null,
                    'address1' => $details['address']['address1'] ?? null,
                    'city' => $details['address']['city'] ?? null,
                    'state' => $details['address']['state'] ?? null,
                    'postal_code' => $details['address']['postal_code'] ?? null,
                    'description' => $details['description'] ?? null,
                    'sic_code' => $details['sic_code'] ?? null,
                    'sic_description' => $details['sic_description'] ?? null,
                    'ticker_root' => $details['ticker_root'] ?? null,
                    'homepage_url' => $details['homepage_url'] ?? null,
                    'total_employees' => $details['total_employees'] ?? null,
                    'list_date' => $details['list_date'] ?? null,
                    'logo_url' => $details['branding']['logo_url'] ?? null,
                    'icon_url' => $details['branding']['icon_url'] ?? null,
                    'share_class_shares_outstanding' => $details['share_class_shares_outstanding'] ?? null,
                    'weighted_shares_outstanding' => $details['weighted_shares_outstanding'] ?? null,
                    'round_lot' => $details['round_lot'] ?? null,
                ]
            );
        }
    }
}
