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
use Auth;

use Illuminate\Support\Collection;

class TransactionController extends Controller
{
  public function checkapi(Request $request)
  {

    if (Auth::User()!=null) {
      return Auth::User();
    }
    return response()->json('Error');
  }

  public function start(Request $request)
  {

    $transactionData = array();

    $startDate = '';
    $endDate = '';

    $cycle = null;

    //Process Transaction by 100 to speed up but not overload.
  //  dd($request[0]);
    for ($i = 0; $i < 100 ; $i++)
    {
      $chunkedData = $request[$i];

      if ($chunkedData['Type'] == 1 || $chunkedData['Type'] == 3)
      { $taxPayer = $this->checkTaxPayer($chunkedData['supplierTaxID'], $chunkedData['supplierName']); }
      else if($chunkedData['Type'] == 2 || $chunkedData['Type'] == 4)
      { $taxPayer = $this->checkTaxPayer($chunkedData['customerTaxID'], $chunkedData['customerName']); }

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

      $transaction->type = $data['Type'] == 2 ? 1 : 3;
    }


    $transaction->customer_id = $customer->id;
    $transaction->supplier_id = $supplier->id;

    //TODO, this is not enough. Remove Cycle, and exchange that for Invoice Date. Since this will tell you better the exchange rate for that day.
    $transaction->currency_id = $this->checkCurrency($data['CurrencyCode'], $taxPayer);
    $transaction->rate = $this->checkCurrencyRate($transaction->currency_id, $taxPayer, $data['Date']) ?? 1;

    $transaction->payment_condition = $data['PaymentCondition'];

    //TODO, do not ask if chart account id is null.
    if ($transaction->account != null && $transaction->payment_condition == 0)
    { $transaction->chart_account_id = $this->checkChartAccount($transaction->account, $taxPayer, $cycle); }

    //You may need to update the code to a Carbon nuetral. Check this, I may be wrong.
    $transaction->date = $this->convert_date($data['Date']);
    $transaction->number = $data['Number'];
    $transaction->code = $data['Code'] != '' ? $data['Code'] : null;
    $transaction->code_expiry = $data['CodeExpiry'] != '' ? $data['CodeExpiry'] : null;
    $transaction->comment = $data['Comment'];
    //$transaction->ref_id = $data['id'];
    $transaction->save();

    $this->processDetail(
      collect($data['CommercialInvoice_Detail']), $transaction->id, $taxPayer, $cycle,$data['Type']
    );

    return $transaction;
  }

  public function processDetail($details, $transaction_id, Taxpayer $taxPayer, Cycle $cycle,$Type)
  {
    //TODO to reduce data stored, group by VAT and Chart Type.
    //If 5 rows can be converted into 1 row it is better for our system's health and reduce server load.

    foreach ($details->groupBy('VATPercentage') as $detailByVAT)
    {
      foreach ($detailByVAT->groupBy('Type') as $groupedRows)
      {
        $detail = new TransactionDetail();
        $detail->transaction_id = $transaction_id;


        $detail->chart_id = $this->checkChart($groupedRows->first()['CostCenter'], $taxPayer, $cycle,$Type);
        $detail->chart_vat_id = $this->checkDebitVAT($groupedRows->first()['VATPercentage'], $taxPayer, $cycle);
        $detail->value = $groupedRows->sum('Value'); //$detail['value'];

        $detail->save();
      }
    }
  }
}
