<?php

namespace App\Http\Controllers\API;

use App\Currency;
use App\CurrencyRate;
use App\Taxpayer;
use App\Chart;
use App\Cycle;


use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkTaxPayer($taxID, $name)
    {
        $cleanTaxID = strtok($taxID , '-');
        $cleanDV = substr($taxID , -1);

        if (is_numeric($cleanTaxID))
        { $customer = Taxpayer::where('taxid', $cleanTaxID)->first(); }
        else
        { $customer = Taxpayer::where('taxid', '88888801')->first(); }

        if (!isset($customer))
        {
            $customer = new taxpayer();
            $customer->name = $name ?? 'No Name';

            if ($cleanTaxID == false)
            {
                $customer->taxid = 88888801;
                $customer->code = null;
            }
            else
            {
                $customer->taxid = $cleanTaxID ?? 88888801;
                $customer->code = is_numeric($cleanDV) ? $cleanDV : null;
            }

            $customer->alias = $name;
            $customer->save();
        }

        return $customer;
    }

    public function checkCurrency($currencyCode, Taxpayer $taxPayer)
    {
        //Check if Chart Exists
        if ($currencyCode != '')
        {
            $currency = Currency::where('code', $currencyCode)
            ->where('country', $taxPayer->country)
            ->first();

            if ($currency == null)
            {
                $currency = new Currency();

                $currency->country = $taxPayer->country;
                $currency->code = $currencyCode;
                $currency->name = $currencyCode;
                $currency->save();
            }

            return $currency->id;
        }

        return null;
    }

    public function checkCurrencyRate($id, Taxpayer $taxPayer, $date)
    {
        $currencyRate = CurrencyRate::where('currency_id',$id)
        ->where('created_at', $this->convert_date($date))
        ->first();

        if (isset($currencyRate))
        { return $currencyRate->rate; }

        return null;
    }

    //These Charts will not work as they use the global scope for Taxpayer and Cycle.
    //you will have to call no global scopes for these methods and then manually assign the same query.

    public function checkChart($costcenter, Taxpayer $taxPayer, Cycle $cycle, $type)
    {

        //Check if Chart Exists
        if (isset($costcenter))
        {
            //Type 1 = Expense
            if ($costcenter[0]['Type'] == 1) {
                $chart = Chart::withoutGlobalScopes()
                ->My($taxPayer, $cycle)
                ->Expenses()
                ->where('name', $costcenter[0]['Name'])
                ->first();
            }
            //Type 2 = Products
            elseif ($costcenter[0]['Type'] == 2)
            {

                if ($type == 1 || $type == 3)
                {
                    $chart = Chart::withoutGlobalScopes()
                    ->My($taxPayer, $cycle)
                    ->SalesAccounts()
                    ->where('name', $costcenter[0]['Name'])
                    ->first();
                }
                else if($type == 2 || $type == 4)
                {
                    $chart = Chart::withoutGlobalScopes()
                    ->My($taxPayer, $cycle)
                    ->PurchaseAccounts()
                    ->where('name', $costcenter[0]['Name'])
                    ->first();
                }
            }
            //Type 3 = FixedAsset
            elseif ($costcenter[0]['Type'] == 3)
            {
                $chart = Chart::withoutGlobalScopes()
                ->My($taxPayer, $cycle)
                ->fixedAssets()
                ->where('name', $costcenter[0]['Name'])
                ->first();
            }
            //Type 4 == Income
            elseif ($costcenter[0]['Type'] == 4)
            {
                $chart = Chart::withoutGlobalScopes()
                ->My($taxPayer, $cycle)
                ->Incomes()
                ->where('name', $costcenter[0]['Name'])
                ->first();
            }

            // $chart = Chart::withoutGlobalScopes()
            // ->My($taxPayer, $cycle)
            // ->SalesAccounts()
            // ->where('name', $costcenter[0]['Name'])
            // ->first();

            if ($chart == null)
            {
                $chart = new Chart();
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = $taxPayer->country;
                $chart->taxpayer_id = $taxPayer->id;
                $chart->is_accountable = true;

                if ($type == 1 || $type == 3)
                {
                    $chart->sub_type = 1;
                    $chart->type = 4;
                }
                else if($type == 2 || $type == 4)
                {
                    $chart->sub_type = 1;
                    $chart->type = 5;
                }

                $chart->code = 'N/A';
                $chart->name = $costcenter[0]['Name'];
                $chart->save();
            }

            return $chart->id;
        }

        return null;
    }

    public function checkDebitVAT($coefficient, Taxpayer $taxPayer, Cycle $cycle)
    {

        //Check if Chart Exists
        if ($coefficient != '')
        {
            $chart = Chart::withoutGlobalScopes()
            ->My($taxPayer, $cycle)
            ->VATDebitAccounts()
            ->where('coefficient', 0.1)
            ->first();

            if ($chart == null)
            {
                $chart = new Chart();
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = $taxPayer->country;
                $chart->taxpayer_id = $taxPayer->id;
                $chart->is_accountable = true;
                $chart->type = 2;
                $chart->sub_type = 3;
                $chart->coefficient = 0.1;

                $chart->code = 'N/A';

                $chart->name = 'Vat Debit';
                $chart->level = 1;

                $chart->save();

            }

            return $chart->id;
        }

        return null;
    }

    public function checkCreditVAT($coefficient, Taxpayer $taxPayer, Cycle $cycle)
    {

        //Check if Chart Exists
        if ($coefficient != '')
        {
            $chart = Chart::withoutGlobalScopes()
            ->My($taxPayer, $cycle)
            ->VATCreditAccounts()
            ->where('coefficient', 0.1)
            ->first();

            if ($chart == null)
            {
                $chart = new Chart();
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = $taxPayer->country;
                $chart->taxpayer_id = $taxPayer->id;
                $chart->is_accountable = true;
                $chart->type = 2;
                $chart->sub_type = 3;
                $chart->coefficient = 0.1;

                $chart->code = 'N/A';

                $chart->name = 'Vat Credit';
                $chart->level = 1;

                $chart->save();

            }

            return $chart->id;
        }

        return null;
    }
    public function checkChartAccount($name, Taxpayer $taxPayer, Cycle $cycle)
    {

        //Check if Chart Exists
        if ($name != '')
        {
            //TODO Wrong, you need to specify taxpayerID or else you risk bringing other accounts not belonging to taxpayer.
            //I have done this already.
            $chart = Chart::withoutGlobalScopes()
            ->My($taxPayer, $cycle)
            ->MoneyAccounts()
            ->where('name', $costcenter['name'])
            ->first();


            if ($chart == null)
            {
                $chart = new Chart();
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = $taxPayer->country;
                $chart->taxpayer_id = $taxPayer->id;
                $chart->is_accountable = true;
                $chart->type = 1;
                $chart->sub_type = 3;

                $chart->code = 'N/A';
                $chart->name = $name;
                $chart->save();
            }

            return $chart->id;
        }

        return null;
    }

    public function convert_date($date)
    {
        $trans_date = $date;
        preg_match('/(\d{10})(\d{3})/', $date, $matches);
        $trans_date = Carbon::createFromTimestamp($matches[1]);
        return $trans_date;
    }
}
