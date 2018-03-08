<?php

namespace App\Http\Controller\API;

use App\Taxpayer;
use App\Chart;
use App\Cycle;
use App\ChartAlias;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  // public function formatData($data)
  // {
  //     return Transaction::make($data)->resolve();
  // }

  public function start(Request $request)
  {
    //Convert data from
    $data = collect(json_decode($request, true));

    //Process Transaction by 100 to speed up but not overload.
    foreach ($data->chunk(100) as $chunkedData)
    {
      $this->processTransaction($chunkedData);
    }
  }

  public function processTransaction($data,$taxpayer,$cycle)
  {
    // //process transaction
    //
    // //process detail
    // $details = $data->detail;
    // $this->processDetail($details);
    // //return transaction saved status (ok or error).
    //
    // $transactions = array(
    //     array('user_id'=>'Coder 1', 'subject_id'=> 4096),
    //     array('user_id'=>'Coder 2', 'subject_id'=> 2048),
    // );
    //
    // Model::insert($transactions);



    $Transaction = new Transaction();
    $Transaction->customer_id =$this->checkTaxPayer($data->gov_code,$data->contact);
    $Transaction->supplier_id =$this->checkTaxPayerCompany($data->gov_code,$data->company) ;
    $Transaction->currency_id = $this->checkCurrency($data->currency,$taxpayer,$cycle);
    $Transaction->rate = $this->checkCurrencyRate($Transaction->currency_id,$taxpayer,$cycle);
    $Transaction->payment_condition = $request->payment_condition;
    if ($request->chart_account_id>0) {
      $Transaction->chart_account_id = $this->checkChartAccount($Transaction->account,$taxpayer,$cycle);
    }
    $Transaction->date = $request->date;
    $Transaction->number = $request->number;
    if ($Transaction->code!='') {
      $Transaction->code = $request->code;
    }
    if ($Transaction->code_expiry!='') {
      $Transaction->code_expiry = $request->code_expiry;
    }

    $Transaction->comment = $request->comment;

    $Transaction->type = 1;
    $Transaction->save();

    $this->processDetail($request->details,$Transaction->id);

  }

  public function processDetail($details,$id)
  {
    foreach ($details as $detail)
    {
      $TransactionDetail = new TransactionDetail();
      $TransactionDetail->transaction_id = $id;
      $TransactionDetail->chart_id =$this->checkChart($detail['chart'],$taxpayer,$cycle);
      $TransactionDetail->chart_vat_id = $this->checkChartVat($detail['vat'],$taxpayer,$cycle);
      $TransactionDetail->value = $detail['value'];
      $TransactionDetail->save();
    }
  }

  public function checkTaxPayerCompany($code,$name,$taxpayer,$cycle)
  {
    if ($name!='') {
      $taxPayer=Taxpayer::where('name', $name)
      ->where('taxid',$code)
      ->first();
      if ($taxPayer==null) {

        $taxPayer= new Taxpayer();
        $taxPayer= new Taxpayer();

      }
      //TODO Country from Selection Box
      $taxPayer->name = $name;
      $taxPayer->taxid = $code;
      $taxPayer->code = $name;


      $taxPayer->save();

      $current_date = Carbon::now();
      $chartVersion = ChartVersion::where('taxpayer_id', $taxPayer->id)->first();
      if (!isset($chartVersion)) {
        $chartVersion = new ChartVersion();
      }

      $chartVersion->name = $current_date->year;
      $chartVersion->taxpayer_id = $taxPayer->id;
      $chartVersion->save();




      $cycle = Cycle::where('chart_version_id', $chartVersion->id)
      ->where('taxpayer_id', $taxPayer->id)
      ->first();
      if (!isset($cycle)) {
        $cycle = new Cycle();
      }

      $cycle->chart_version_id = $chartVersion->id;
      $cycle->year = $current_date->year;
      $cycle->start_date = new Carbon('first day of January');
      $cycle->end_date = new Carbon('last day of December');
      $cycle->taxpayer_id = $taxPayer->id;
      $cycle->save();




    }
  }
}

public function checkChart($name,$taxpayer,$cycle)
{
  //Check if Chart Exists
  if ($name!='') {
    $chart=Chart::SalesAccounts()->where('name', $name)->first();
    if ($chart==null) {

      $chart= new Chart();



      $chart->chart_version_id = $cycle->chart_version_id;
      $chart->country = $taxPayer->country;
      $chart->taxpayer_id = $taxPayer->id;
      $chart->is_accountable = 1;
      $chart->sub_type = 9;
      $chart->type =1;

      $chart->code = $name;
      $chart->name = $name;
      $chart->save();

    }
  }
  //If not Create with Taxpayer ID and Country as reference.

  //Return Chart Object or ID
}
public function checkChartVat($name,$taxpayer,$cycle)
{
  //Check if Chart Exists
  if ($name!='') {
    $chart=Chart::VATDebitAccounts()->where('name', $name)->first();
    if ($chart==null) {

      $chart= new Chart();



      $chart->chart_version_id = $cycle->chart_version_id;
      $chart->country = $taxPayer->country;
      $chart->taxpayer_id = $taxPayer->id;
      $chart->is_accountable = 1;
      $chart->type =2;
      $chart->sub_type = 3;


      $chart->code = $name;
      $chart->name = $name;
      $chart->save();

    }
  }
  //If not Create with Taxpayer ID and Country as reference.

  //Return Chart Object or ID
}
public function checkChartAccount($name,$taxpayer,$cycle)
{
  //Check if Chart Exists
  if ($name!='') {
    $chart=Chart::MoneyAccounts()->where('name', $name)->first();
    if ($chart==null) {

      $chart= new Chart();



      $chart->chart_version_id = $cycle->chart_version_id;
      $chart->country = $taxPayer->country;
      $chart->taxpayer_id = $taxPayer->id;
      $chart->is_accountable = 1;
      $chart->type =1;
      $chart->sub_type = 3;


      $chart->code = $name;
      $chart->name = $name;
      $chart->save();

    }
  }
  //If not Create with Taxpayer ID and Country as reference.

  //Return Chart Object or ID
}
}
