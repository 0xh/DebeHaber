<?php

namespace App\Http\Controllers\API;

use App\Taxpayer;
use App\Chart;
use App\ChartVersion;
use App\Currency;
use App\CurrencyRate;
use App\Cycle;
use App\ChartAlias ;
use App\Transaction;
use App\AccountMovement;
use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use DB;
use Auth;

class AccountMovementController extends Controller
{
    public function start(Request $request)
    {
        $movementData = array();

        $startDate = '';
        $endDate = '';

        $cycle = null;

        //Process Transaction by 100 to speed up but not overload.
        for ($i = 0; $i < 100 ; $i++)
        {
            $chunkedData = $request[$i];

            if (isset($chunkedData))
            {

                $taxPayer = $this->checkTaxPayer($chunkedData['CustomerTaxID'], $chunkedData['CustomerName']);


                //No need to run this query for each invoice, just check if the date is in between.
                $cycle = Cycle::where('start_date', '<=', $this->convert_date($chunkedData['Date']))
                ->where('end_date', '>=', $this->convert_date($chunkedData['Date']))
                ->where('taxpayer_id', $taxPayer->id)
                ->first();

                if (!isset($cycle))
                {
                    $current_date = Carbon::now();
                    $version = ChartVersion::where('taxpayer_id', $taxPayer->id)->first();

                    if (!isset($version))
                    {
                        $version = new ChartVersion();
                        $version->taxpayer_id = $taxPayer->id;
                        $version->name = 'Version Automatica';
                        $version->save();
                    }

                    $cycle = new Cycle();
                    $cycle->chart_version_id = $version->id;
                    $cycle->year = $current_date->year;
                    $cycle->start_date = new Carbon('first day of January');
                    $cycle->end_date = new Carbon('last day of December');
                    $cycle->taxpayer_id = $taxPayer->id;
                    $cycle->save();

                }
                else
                {
                    $startDate = $cycle->start_date;
                    $endDate = $cycle->end_date;
                }

                try
                {
                    $accMovement = $this->processTransaction($chunkedData, $taxPayer, $cycle);
                    $movementData[$i] = $accMovement;
                }
                catch (\Exception $e)
                {
                    //Write items that don't insert into a variable and send back to ERP.
                    //Do Nothing
                }
            }
        }

        return response()->json($movementData);
    }

    public function processTransaction($data, Taxpayer $taxPayer, Cycle $cycle)
    {
        $accMovement = $this->processPayments($data, $taxPayer, $cycle);
        //Return account movement if not null.
        return $accMovement != null ? $accMovement : null;
    }

    public function processPayments($data, $taxPayer, $cycle)
    {
        $accMovement = new AccountMovement();
        $chartID = $this->checkChartAccount($data['AccountName'], $taxPayer, $cycle);

        $accMovement->chart_id = $chartID;
        $accMovement->taxpayer_id = $taxPayer->id;
        $accMovement->currency_id = $this->checkCurrency($data['CurrencyCode'], $taxPayer);

        //Check currency rate based on date. if nothing found use default from api. TODO this should be updated to buy and sell rates.
        if ($data['CurrencyRate'] ==  '' )
        { $accMovement->rate = $this->checkCurrencyRate($accMovement->currency_id, $taxPayer, $data['Date']) ?? 1; }
        else
        { $accMovement->rate = $data['CurrencyRate'] ?? 1; }

        $accMovement->date = $this->convert_date($data['Date']);
        //based on invoice type choose if its credit or debit.
        $accMovement->credit =  $data['Credit'];
        $accMovement->debit =  $data['Debit'];

        $accMovement->comment = $data['Comment'];

        $accMovement->save();

        return $accMovement;
    }


    //Simple movements from one account to another. Maybe this should create two movements to demonstrate how it goes from one account into another.
    public function processMovement($taxPayer, $data)
    {
        $accMovement = new AccountMovement();
        $accMovement->chart_id = $this->checkChartAccount($data['AccountName'], $taxPayer, $cycle);
        $accMovement->taxpayer_id = $taxPayer->id;
        $accMovement->currency_id = $this->checkCurrency($data['CurrencyCode'], $taxPayer);

        //Check currency rate based on date. if nothing found use default from api. TODO this should be updated to buy and sell rates.
        if ($data['CurrencyRate'] ==  '' )
        { $accMovement->rate = $this->checkCurrencyRate($accMovement->currency_id, $taxPayer, $data['Date']) ?? 1; }
        else
        { $accMovement->rate = $data['CurrencyRate'] ?? 1; }

        $accMovement->date = $this->convert_date($data['Date']);
        $accMovement->credit = $data['Credit'] ?? 0;
        $accMovement->debit = $data['Debit'] ?? 0;

        $accMovement->comment = $data['Comment'];
        $accMovement->save();

        return $accMovement;
    }
}
