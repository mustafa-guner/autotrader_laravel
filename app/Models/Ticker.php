<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TickerDetail
 * @package App\Models
 * @property int id
 * @property string ticker
 * @property string name
 * @property string market
 * @property string locale
 * @property string primary_exchange
 * @property string type
 * @property bool active
 * @property string currency_name
 * @property string cik
 * @property string composite_figi
 * @property string share_class_figi
 * @property string market_cap
 * @property string phone_number
 * @property string address1
 * @property string city
 * @property string state
 * @property string postal_code
 * @property string description
 * @property string sic_code
 * @property string sic_description
 * @property string ticker_root
 * @property string homepage_url
 * @property string total_employees
 * @property string list_date
 * @property string logo_url
 * @property string icon_url
 * @property string share_class_shares_outstanding
 * @property string weighted_shares_outstanding
 * @property string round_lot
 * @property string created_at
 */
class Ticker extends Model
{
    use HasFactory;

    protected $table = 'tickers';

    protected $fillable = [
        'ticker',
        'name',
        'market',
        'locale',
        'primary_exchange',
        'type',
        'active',
        'currency_name',
        'cik',
        'composite_figi',
        'share_class_figi',
        'market_cap',
        'phone_number',
        'address1',
        'city',
        'state',
        'postal_code',
        'description',
        'sic_code',
        'sic_description',
        'ticker_root',
        'homepage_url',
        'total_employees',
        'list_date',
        'logo_url',
        'icon_url',
        'share_class_shares_outstanding',
        'weighted_shares_outstanding',
        'round_lot',
    ];
}
