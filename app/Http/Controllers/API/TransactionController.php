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
use App\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use DB;
use Auth;

class TransactionController extends Controller
{
    public function start(Request $request)
    {
        $transactionData = array();

        $startDate = '';
        $endDate = '';

        $cycle = null;

        //Process Transaction by 100 to speed up but not overload.
        for ($i = 0; $i < 100 ; $i++)
        {
            $chunkedData = $request[$i];

            if (isset($chunkedData))
            {
                if ($chunkedData['Type'] == 4 || $chunkedData['Type'] == 5)
                { $taxPayer = $this->checkTaxPayer($chunkedData['SupplierTaxID'], $chunkedData['SupplierName']); }
                else if($chunkedData['Type'] == 3 || $chunkedData['Type'] == 1)
                { $taxPayer = $this->checkTaxPayer($chunkedData['CustomerTaxID'], $chunkedData['CustomerName']); }

                //groupby function group by year.
                foreach ($chunkedData->groupBy(function($q) { return Carbon::parse($q->Date)->format('Y'); }) as $groupedRow)
                {
                    //check and create cycle
                    $oneDate = Carbon::parse($groupedRow->first()->Date);

                    //No need to run this query for each invoice, just check if the date is in between.
                    $cycle = Cycle::where('start_date', '<=', $oneDate)
                    ->where('end_date', '>=', $oneDate)
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
                        $cycle->start_date = new Carbon('first day of January ' . $this->convert_date($chunkedData['Date'])->year);
                        $cycle->end_date = new Carbon('last day of December ' . $this->convert_date($chunkedData['Date'])->year);
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
                        $filteredData = $chunkedData->where(function($q) use($currentDate) {  $q->where('Date', Carbon::parse($currentDate)->format('Y')); })->get();
                        $transaction = $this->processTransaction($chunkedData->where('Date'), $taxPayer, $cycle);
                        $transactionData[$i] = $transaction;
                    }
                    catch (\Exception $e)
                    {
                        //Write items that don't insert into a variable and send back to ERP.
                        //Do Nothing
                    }
                }
            }
        }

        return response()->json($transactionData);
    }

    public function processTransaction($data, Taxpayer $taxPayer, Cycle $cycle)
    {
        //TODO. There should be logic that checks if RefID for this Taxpayer is already int the system. If so, then only update, or else create.
        //Im not too happy with this code since it will call db every time there is a new invoice. Maybe there is a better way, or simply remove this part and insert it again.
        $transaction = new Transaction();

        // 4 & 5, then is Sales or Credit Note. So Customer is our client, and current Taxpayer is Supplier
        if ($data['Type'] == 4 || $data['Type'] == 5)
        {
            $customer = $this->checkTaxPayer($data['CustomerTaxID'], $data['CustomerName']);
            $supplier = $taxPayer;

            $transaction->type = $data['Type'];
        }
        //If type 1 & 3, then it is Purchase or Debit Note. So we should bring our supplier and current Taxpayer is Customer
        else if($data['Type'] == 1 || $data['Type'] == 3)
        {
            $customer = $taxPayer;
            $supplier = $this->checkTaxPayer($data['SupplierTaxID'], $data['SupplierName']);

            $transaction->type = $data['Type'];
        }

        $transaction->customer_id = $customer->id;
        $transaction->supplier_id = $supplier->id;

        //TODO, this is not enough. Remove Cycle, and exchange that for Invoice Date. Since this will tell you better the exchange rate for that day.
        $transaction->currency_id = $this->checkCurrency($data['CurrencyCode'], $taxPayer);

        if ($data['CurrencyRate'] ==  '' )
        {
            $transaction->rate = $this->checkCurrencyRate($transaction->currency_id, $taxPayer, $data['Date']) ?? 1;
        }
        else
        {
            $transaction->rate = $data['CurrencyRate'];
        }

        $transaction->payment_condition = $data['PaymentCondition'];

        // //TODO, do not ask if chart account id is null.
        // if ($data['AccountName'] != null && $transaction->payment_condition == 0)
        // {
        //
        //     $transaction->chart_account_id = $this->checkChartAccount($data['AccountName'], $taxPayer, $cycle);
        // }

        //You may need to update the code to a Carbon nuetral. Check this, I may be wrong.
        $transaction->date = $this->convert_date($data['Date']);
        $transaction->number = $data['Number'];
        $transaction->code = $data['Code'] != '' ? $data['Code'] : null;
        $transaction->code_expiry = $data['CodeExpiry'] != '' ? $this->convert_date($data['CodeExpiry'])  : null;
        $transaction->comment = $data['Comment'];
        $transaction->save();

        //Process details of the invoice.
        $this->processDetail(
            collect($data['Details']), $transaction->id, $taxPayer, $cycle, $data['Type']
        );

        return $transaction;
    }

    public function processDetail($details, $transaction_id, Taxpayer $taxPayer, Cycle $cycle, $type)
    {
        //TODO to reduce data stored, group by VAT and Chart Type.
        //If 5 rows can be converted into 1 row it is better for our system's health and reduce server load.
        foreach ($details->groupBy('VATPercentage') as $detailByVAT)
        {
            foreach ($detailByVAT->groupBy('Type') as $groupedRows)
            {

                $detail = new TransactionDetail();
                $detail->transaction_id = $transaction_id;

                $detail->chart_id = $this->checkChart($groupedRows[0]['Type'], $groupedRows[0]['Name'], $taxPayer, $cycle, $type);

                if ($type == 1 || $type == 5)
                { $detail->chart_vat_id = $this->checkCreditVAT($groupedRows[0]['VATPercentage'], $taxPayer, $cycle); }
                elseif ($type == 3 || $type == 4)
                { $detail->chart_vat_id = $this->checkDebitVAT($groupedRows[0]['VATPercentage'], $taxPayer, $cycle); }

                $detail->value = $groupedRows->sum('Value');

                $detail->save();
            }
        }
    }
}
