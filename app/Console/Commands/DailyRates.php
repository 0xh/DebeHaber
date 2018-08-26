<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\CurrencyRate;
use Carbon\Carbon;

class DailyRates extends Command
{
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'currency:rates';

    /**
    * The console command description.
    *
    * @var string
    */
    protected $description = 'Gathers the daily rates for the currencies and inserts into rates table.';

    /**
    * Create a new command instance.
    *
    * @return void
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * Execute the console command.
    *
    * @return mixed
    */
    public function handle()
    {
        ###
        ### Paraguay USD rate
        ###
        $client = new Client(['base_uri' => 'https://dolar.melizeche.com/']);
        $response = $client->request('GET', 'api/1.0/');
        $arr = json_decode($response->getBody(), true);

        //Get updated date
        $fx = CurrencyRate::whereDate('date', '=', Carbon::parse($arr['updated'])->startOfDay()->addDay()->toDateString())
        ->where('currency_id', 2)
        ->first();

        //If doesn't exists for that day, then create it.
        //If it exists, ignore it.
        if (!isset($fx))
        {
            $fx = new CurrencyRate();
            $fx->currency_id = 2; //USD
            $fx->date = Carbon::parse($arr['updated'])->startOfDay()->addDay();
            $fx->buy_rate = $arr['dolarpy']['set']['compra'];
            $fx->sell_rate = $arr['dolarpy']['set']['venta'];
            $fx->save();
        }

        ###
        ### Swap Rates
        ###
    }
}
