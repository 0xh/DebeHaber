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
use Carbon\Carbon;

use Illuminate\Support\Collection;

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
      $chunkedData = $request[$i]['Commercial_Invoices'][0];

      if ($chunkedData['Type'] == 1 || $chunkedData['Type'] == 3)
      { $taxPayer = $this->checkTaxPayer($chunkedData['supplierTaxID'], $chunkedData['supplierName']); }
      else if($chunkedData['Type'] == 2 || $chunkedData['Type'] == 4)
      { $taxPayer = $this->checkTaxPayer($chunkedData['customerTaxID'], $chunkedData['customerName']); }

      //No need to run this query for each invoice, just check if the date is in between.
      $cycle = Cycle::where('start_date', '<=', $this->convert_date($chunkedData['date']))
      ->where('end_date', '>=', $this->convert_date($chunkedData['date']))
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
        $transaction = $this->processTransaction($chunkedData, $taxPayer, $cycle);
        $transactionData[$i] = $transaction;
      }
      catch (\Exception $e)
      {
        //Write items that don't insert into a variable and send back to ERP.
      }


    }

    return response()->json($transactionData);
  }

  public function processTransaction($data, Taxpayer $taxPayer, Cycle $cycle)
  {
    //TODO. There should be logic that checks if RefID for this Taxpayer is already int the system. If so, then only update, or else create.
    //Im not too happy with this code since it will call db every time there is a new invoice. Maybe there is a better way, or simply remove this part and insert it again.
    $transaction = new Transaction();

    if ($data['Type'] == 1 || $data['Type'] == 3)
    {
      $customer = $this->checkTaxPayer($data['customerTaxID'], $data['customerName']);
      $supplier = $taxPayer;

      $transaction->type = $data['Type'] == 1 ? 4 : 5;
    }
    else if($data['Type'] == 2 || $data['Type'] == 4)
    {
      $customer = $taxPayer;
      $supplier = $this->checkTaxPayer($data['supplierTaxID'], $data['supplierName']);

      $transaction->type = $datab['Type'] == 2 ? 1 : 3;
    }


    $transaction->customer_id = $customer->id;
    $transaction->supplier_id = $supplier->id;

    //TODO, this is not enough. Remove Cycle, and exchange that for Invoice Date. Since this will tell you better the exchange rate for that day.
    $transaction->currency_id = $this->checkCurrency($data['currencyCode'], $taxPayer);
    $transaction->rate = $this->checkCurrencyRate($transaction->currency_id, $taxPayer, $data['date']) ?? 1;

    $transaction->payment_condition = $data['paymentCondition'];

    //TODO, do not ask if chart account id is null.
    if ($transaction->account != null && $transaction->payment_condition == 0)
    { $transaction->chart_account_id = $this->checkChartAccount($transaction->account, $taxPayer, $cycle); }

    //You may need to update the code to a Carbon nuetral. Check this, I may be wrong.
    $transaction->date = $this->convert_date($data['date']);
    $transaction->number = $data['number'];
    $transaction->code = $data['code'] != '' ? $data['code'] : null;
    $transaction->code_expiry = $data['code_expiry'] != '' ? $data['code_expiry'] : null;
    $transaction->comment = $data['comment'];
    $transaction->ref_id = $data['id'];
    $transaction->save();

    $this->processDetail(
      collect($data['CommercialInvoice_Detail']), $transaction->id, $taxPayer, $cycle, $data['Type']
    );

    return $transaction;
  }

  public function processDetail($details, $transaction_id, Taxpayer $taxPayer, Cycle $cycle, $type)
  {

    //TODO to reduce data stored, group by VAT and Chart Type.
    //If 5 rows can be converted into 1 row it is better for our system's health and reduce server load.

    foreach ($details->groupBy('vat') as $detailByVAT)
    {
      foreach ($detailByVAT->groupBy('chart') as $groupedRows)
      {

        $detail = new TransactionDetail();
        $detail->transaction_id = $transaction_id;

        $detail->chart_id = $this->checkChart($groupedRows->first()['CostCenter'], $taxPayer, $cycle,$type);
        if ($type == 1 || $type == 3)
        {
        $detail->chart_vat_id = $this->checkDebitVAT($groupedRows->first()['coefficient'], $taxPayer, $cycle);
        }
        else if($type == 2 || $type == 4)
        {
          $detail->chart_vat_id = $this->checkCreditVAT($groupedRows->first()['coefficient'], $taxPayer, $cycle);
        }

        $detail->value = $groupedRows->sum('value'); //$detail['value'];

        $detail->save();
      }
    }
  }


}
