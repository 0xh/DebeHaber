<?php

namespace App\Http\Controllers\RESTful;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\CurrencyRate;
use Carbon\Carbon;

class CurrencyRatesController extends Controller
{
    protected static function boot()
    {
        parent::boot();
        $this->getRates();
    }

    public function getRates()
    {
        //Create functions to run in sequence. This code will run twice a day.
        $this->pryUSD();
    }

    public function pryUSD()
    {
        $client = new Client(['base_uri' => 'https://dolar.melizeche.com/']);
        $response = $client->request('GET', 'api/1.0/');
        $arr = json_decode($response->getBody(), true);

        //Get updated date
        $fx = CurrencyRate::whereDate('date', '=', Carbon::parse($arr['updated'])->toDateString())
        ->where('currency_id', 2)
        ->first();

        //If doesn't exists for that day, then create it.
        //If it exists, ignore it.
        if (!isset($fx))
        {
            $fx = new CurrencyRate();
            $fx->currency_id = 2; //USD
            $fx->date = Carbon::parse($arr['updated'])->startOfDay();
            $fx->buy_rate = $arr['dolarpy']['set']['compra'];
            $fx->sell_rate = $arr['dolarpy']['set']['venta'];
            $fx->save();
        }
    }
}
