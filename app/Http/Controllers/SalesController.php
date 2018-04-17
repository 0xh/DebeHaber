<?php

namespace App\Http\Controllers;

use App\AccountMovement;
use App\JournalTransaction;
use App\Taxpayer;
use App\Cycle;
use App\Chart;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class SalesController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Taxpayer $taxPayer, Cycle $cycle)
  {
    $charts = Chart::SalesAccounts()
    ->orderBy('name')
    ->select('name', 'id', 'type')
    ->get();

    $vats = Chart::
    VATDebitAccounts()
    ->select('name', 'code', 'id', 'coefficient')
    ->get();

    $accounts = Chart::MoneyAccounts()->orderBy('name')
    ->select('name', 'id', 'sub_type')
    ->get();


    return view('/commercial/sales')->with('charts',$charts)
    ->with('vats',$vats)
    ->with('accounts',$accounts);
  }

  public function get_sales(Taxpayer $taxPayer, Cycle $cycle, $skip)
  {

    $transaction = Transaction::MySales()
    ->join('taxpayers', 'taxpayers.id', 'transactions.customer_id')
    ->join('currencies', 'transactions.currency_id','currencies.id')
    ->leftjoin('statuses', 'transactions.id','statuses.model_id')
    ->leftJoin('transaction_details as td', 'td.transaction_id', 'transactions.id')
    ->where('supplier_id', $taxPayer->id)
    ->whereBetween('date', [$cycle->start_date, $cycle->end_date])
    ->groupBy('transactions.id')
    ->select(DB::raw('max(transactions.id) as ID'),
    DB::raw('max(taxpayers.name) as Customer'),
    DB::raw('max(taxpayers.taxid) as CustomerTaxID'),
    DB::raw('max(currencies.code) as Currency'),
    DB::raw('max(transactions.payment_condition) as PaymentCondition'),
    DB::raw('max(transactions.date) as Date'),
    DB::raw('max(transactions.number) as Number'),
    DB::raw('if(max(statuses.name)="Annul",0,sum(td.value)) as Value'))
    ->orderByRaw('max(transactions.date)', 'desc')
    ->orderByRaw('max(transactions.number)', 'desc')
    ->skip($skip)
    ->take(100)
    ->get();

    return response()->json($transaction, 200);
  }

  public function getLastSale($partnerID)
  {
    $transaction = Transaction::MySales()
    ->join('taxpayers', 'taxpayers.id', 'transactions.customer_id')
    ->where('customer_id', $partnerID)
    ->with('details')
    ->orderBy('date', 'desc')
    ->select(DB::raw('transactions.id,taxpayers.name as Supplier
    ,supplier_id,document_id,currency_id,rate,payment_condition,chart_account_id,date
    ,number,transactions.code,code_expiry'))
    ->first();

    return response()->json($transaction, 200);
  }


  public function get_salesByID(Taxpayer $taxPayer, Cycle $cycle, $id)
  {
    $transaction = Transaction::MySales()->join('taxpayers', 'taxpayers.id', 'transactions.customer_id')
    ->where('supplier_id', $taxPayer->id)
    ->where('transactions.id', $id)
    ->with('details')
    ->select(DB::raw('false as selected,transactions.id,
    taxpayers.name as customer,
    customer_id,
    document_id,
    currency_id,
    rate,
    payment_condition,
    chart_account_id,
    date,
    number,
    transactions.code,code_expiry'))
    ->get();

    return response()->json($transaction, 200);
  }

  public function get_lastDate($taxPayerID, Cycle $cycle)
  {
    $lastDate = Transaction::MySales()
    ->where('supplier_id', $taxPayerID)
    ->orderBy('created_at', 'desc')
    ->select(DB::raw('date'))
    ->first();

    if (isset($lastDate))
    { return response()->json($lastDate->date->format('Y-m-d')); }
    else
    { return response()->json(Carbon::now()->format('Y-m-d')); }
  }

  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    //
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request, Taxpayer $taxPayer,Cycle $cycle)
  {

    $transaction = $request->id == 0 ? new Transaction() : Transaction::where('id', $request->id)->first();

    if ($request->customer_id > 0)
    {
      $transaction->customer_id = $request->customer_id;
    }

    $transaction->supplier_id = $taxPayer->id;

    if ($request->document_id > 0)
    {
      $transaction->document_id = $request->document_id;
    }

    $transaction->currency_id = $request->currency_id;
    $transaction->rate = $request->rate;
    $transaction->payment_condition = $request->payment_condition;

    if ($request->chart_account_id > 0)
    {
      $transaction->chart_account_id = $request->chart_account_id;
    }

    $transaction->date = $request->date;
    $transaction->number = $request->number;

    if ($transaction->code != '')
    {
      $transaction->code = $request->code;
    }

    if ($transaction->code_expiry != '')
    {
      $transaction->code_expiry = $request->code_expiry;
    }

    $transaction->comment = $request->comment;
    $transaction->type = $request->type;
    $transaction->save();

    foreach ($request->details as $detail)
    {
      if ($detail['id'] == 0)
      {
        $transactionDetail = new TransactionDetail();
      }
      else
      {
        $transactionDetail = TransactionDetail::where('id',$detail['id'])->first();
      }

      $transactionDetail->transaction_id = $transaction->id;
      $transactionDetail->chart_id = $detail['chart_id'];
      $transactionDetail->chart_vat_id = $detail['chart_vat_id'];
      $transactionDetail->value = $detail['value'];
      $transactionDetail->save();
    }

    return response()->json('ok', 200);
  }

  /**
  * Display the specified resource, in non-edit mode to prevent unauthorized changes.
  *
  * @param  \App\Transaction  $transaction
  * @return \Illuminate\Http\Response
  */
  public function show(Transaction $transaction, Taxpayer $taxPayer, Cycle $cycle)
  {
    return view('/commercial/sales/show')->with('transaction', $transaction);
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Transaction  $transaction
  * @return \Illuminate\Http\Response
  */
  public function edit(Transaction $transaction)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Transaction  $transaction
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Transaction $transaction)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Transaction  $transaction
  * @return \Illuminate\Http\Response
  */
  public function destroy(Taxpayer $taxPayer, Cycle $cycle,$transactionID)
  {
    try
    {

      //TODO: Run Tests to make sure it deletes all journals related to transaction
      AccountMovement::where('transaction_id', $transactionID)->delete();
      JournalTransaction::where('transaction_id',$transactionID)->delete();
      Transaction::where('id',$transactionID)->delete();

      return response()->json('ok', 200);
    }
    catch (\Exception $e)
    {
      return response()->json($e, 500);
    }
  }
  public function anull(Taxpayer $taxPayer, Cycle $cycle,$transactionID)
  {
    try
    {

      $transaction = Transaction::find($transactionID);

      if (isset($transaction))
      {
        $transaction->setStatus('Annul');
      }

      return response()->json('ok', 200);
    }
    catch (\Exception $e)
    {
      return response()->json($e, 500);
    }
  }
}
