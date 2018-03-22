<?php

namespace App\Http\Controllers\API;

use App\Taxpayer;
use App\Chart;
use App\ChartVersion;
use App\Currency;
use App\CurrencyRate;
use App\Cycle;
use App\ChartAlias;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function start(Request $request)
    {

        $transactionData = array();

        //Process Transaction by 100 to speed up but not overload.
        for ($i = 0; $i < 100 ; $i++)
        {
            $chunkedData = $request[$i]['Commercial_Invoices'][0];

            if ($chunkedData['Type'] == 1 || $chunkedData['Type'] == 3)
            {
                $taxpayer = $this->checkTaxPayer($chunkedData['supplierTaxID'], $chunkedData['supplierName']);
            }
            else if($chunkedData['Type'] == 2 || $chunkedData['Type'] == 4)
            {
                $taxpayer = $this->checkTaxPayer($chunkedData['customerTaxID'], $chunkedData['customerName']);
            }

            $cycle = Cycle::where('start_date', '<=', $this->convert_date($chunkedData['date']))
            ->where('end_date', '>=', $this->convert_date($chunkedData['date']))
            ->where('taxpayer_id', $taxpayer->id)->first();

            if (!isset($cycle))
            {
                $current_date = Carbon::now();
                $chartVersion = ChartVersion::where('taxpayer_id', $taxpayer->id)->first();

                if (!isset($chartVersion))
                { $chartVersion = new ChartVersion(); }

                $chartVersion->name = $current_date->year;
                $chartVersion->taxpayer_id = $taxpayer->id;
                $chartVersion->save();

                $cycle = new Cycle();
                $cycle->chart_version_id = $chartVersion->id;
                $cycle->year = $current_date->year;
                $cycle->start_date = new Carbon('first day of January');
                $cycle->end_date = new Carbon('last day of December');
                $cycle->taxpayer_id = $taxpayer->id;
                $cycle->save();
            }

            $transaction = $this->processTransaction($chunkedData,$taxpayer,$cycle);
            $transactionData[$i] = $transaction;
        }

        return response()->json($transactionData);
    }

    public function processTransaction($data, $taxpayer,$cycle)
    {
        //TODO. There should be logic that checks if RefID for this Taxpayer is already int the system. If so, then only update, or else create.
        //Im not too happy with this code since it will call db every time there is a new invoice. Maybe there is a better way, or simply remove this part and insert it again.

        $transaction = Transaction::where('ref_id', $data['id'])->first() ?? new Transaction();

        if ($data['Type'] == 1 || $data['Type'] == 3)
        {
            $customer = $this->checkTaxPayer($data['customerTaxID'], $data['customerName']);
            $supplier = $taxpayer;

            $transaction->type = $data['Type'] == 1 ? 4 : 5;
        }
        else if($data['Type'] == 2 || $data['Type'] == 4)
        {
            $customer = $taxpayer;
            $supplier = $this->checkTaxPayer($data['supplierTaxID'], $data['supplierName']);

            $transaction->type = $datab['Type'] == 2 ? 1 : 3;
        }

        $transaction->type = 4;
        $transaction->customer_id = $customer->id;
        $transaction->supplier_id = $supplier->id;

        $transaction->currency_id = $this->checkCurrency($data['currencyCode'], $taxpayer);

        //TODO, this is not enough. Remove Cycle, and exchange that for Invoice Date. Since this will tell you better the exchange rate for that day.
        $transaction->rate = $this->checkCurrencyRate($transaction->currency_id, $taxpayer, $data['date']) ??1;

        $transaction->payment_condition = $data['paymentCondition'];

        //TODO, do not ask if chart account id is null.
        if ($transaction->account != null)
        {
            $transaction->chart_account_id = $this->checkChartAccount($transaction->account, $taxpayer, $cycle);
        }

        //You may need to update the code to a Carbon nuetral. Check this, I may be wrong.
        $transaction->date = $this->convert_date($data['date']);
        $transaction->number = $data['number'];
        $transaction->code = $data['code'] != '' ? $data['code'] : null;
        $transaction->code_expiry = $data['code_expiry'] != '' ? $data['code_expiry'] : null;
        $transaction->comment = $data['comment'];
        $transaction->ref_id = $data['id'];
        $transaction->save();

        $this->processDetail($data['CommercialInvoice_Detail'],$taxpayer,$transaction->id,$cycle);
        return $transaction;
    }

    public function convert_date($date)
    {
        $trans_date = $date;

        preg_match('/(\d{10})(\d{3})/', $date, $matches);

        $trans_date = Carbon::createFromTimestamp($matches[1]);
        return $trans_date;
    }

    public function processDetail($details,$taxpayer, $transaction_id,$cycle)
    {
        foreach ($details as $detail)
        {
            $transactionDetail = new TransactionDetail();
            $transactionDetail->transaction_id = $transaction_id;
            $transactionDetail->chart_id = $this->checkChart($detail['chart'], $taxpayer, $cycle);
            $transactionDetail->chart_vat_id = $this->checkDebitVAT($detail['vat'], $taxpayer, $cycle);
            $transactionDetail->value = $detail['value'];

            $transactionDetail->save();
        }
    }

    public function checkTaxPayer($taxid, $name)
    {
        $cleanTaxID = strtok($taxid , '-');
        $cleanDV = substr($taxid , -1);

        if (is_numeric($cleanTaxID))
        {
            $customer = Taxpayer::where('taxid', $cleanTaxID)->first();
        }
        else
        {
            $customer = Taxpayer::where('taxid', '88888801')->first();
        }

        if (!isset($customer))
        {
            $customer = new taxpayer();
            $customer->name = $name ?? 'No Name';

            if ($cleanTaxID == false)
            {
                $customer->taxid = 88888801;
                $customer->code = 00000;
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

    public function checkCurrency($code, $taxpayer)
    {
        //Check if Chart Exists
        if ($code != '')
        {
            $currency = Currency::where('code', $code)
            ->where('country', $taxpayer->country)
            ->first();

            if ($currency == null)
            {
                $currency = new Currency();

                $currency->country = 'PRY';
                $currency->code = $code;
                $currency->name = $code;
                $currency->save();
            }

            return $currency->id;
        }

        return null;
    }

    public function checkCurrencyRate($id,$taxpayer,$date)
    {
        $currencyRate=CurrencyRate::where('currency_id',$id)
        ->where('created_at', $this->convert_date($date))
        ->first();

        if (isset($currencyRate))
        {
            return $currencyRate->rate;
        }

        return null;
    }

    //These Charts will not work as they use the global scope for Taxpayer and Cycle.
    //you will have to call no global scopes for these methods and then manually assign the same query.

    public function checkChart($name, $taxPayer, $cycle)
    {
        //Check if Chart Exists
        if ($name != '')
        {
            $chart = Chart::withoutGlobalScopes()
            ->My($taxPayer, $cycle)
            ->SalesAccounts()
            ->where('name', $name)
            ->first();

            if ($chart == null)
            {
                $chart = new Chart();

                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = 'PRY';
                $chart->taxpayer_id = $taxpayer->id;
                $chart->is_accountable = true;
                $chart->sub_type = 9;
                $chart->type = 1;

                $chart->code = 'N/A';
                $chart->name = $name;
                $chart->save();
            }

            return $chart->id;
        }

        return null;
    }

    public function checkDebitVAT($name,$taxPayer,$cycle)
    {
        //Check if Chart Exists
        if ($name != '')
        {
            $chart = Chart::withoutGlobalScopes()
            ->My($taxPayer, $cycle)
            ->VATDebitAccounts()
            ->where('name', $name)
            ->first();

            if ($chart == null)
            {
                $chart = new Chart();
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = 'PRY';
                $chart->taxpayer_id = $taxPayer->id;
                $chart->is_accountable = true;
                $chart->type = 2;
                $chart->sub_type = 3;

                $chart->code = 'N/A';
                $chart->name = $name;
                $chart->save();
            }

            return $chart->id;
        }

        return null;
    }

    public function checkChartAccount($name, $taxPayer, $cycle)
    {
        //Check if Chart Exists
        if ($name != '')
        {
            //TODO Wrong, you need to specify taxpayerID or else you risk bringing other accounts not belonging to taxpayer.
            //I have done this already.
            $chart = Chart::withoutGlobalScopes()
            ->My($taxPayer, $cycle)
            ->MoneyAccounts()
            ->where('name', $name)
            ->first();

            if ($chart == null)
            {
                $chart = new Chart();
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = 'PRY';
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
}
