<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Taxpayer;
use App\Cycle;
use App\AccountMovement;
use Illuminate\Http\Request;
use DB;

class AccountPayableController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Taxpayer $taxPayer, Cycle $cycle)
  {
    return view('/commercial/accounts-payable');
  }

  public function get_account_payable(Taxpayer $taxPayer, Cycle $cycle, $skip)
  {
    $transactions = Transaction::MyPurchases()
    ->join('taxpayers', 'taxpayers.id', 'transactions.supplier_id')
    ->join('currencies', 'transactions.currency_id','currencies.id')
    ->join('transaction_details as td', 'td.transaction_id', 'transactions.id')
    ->leftJoin('account_movements', 'transactions.id', 'account_movements.transaction_id')
    ->where('transactions.customer_id', $taxPayer->id)
    ->where('transactions.payment_condition', '>', 0)
    //->whereRaw('ifnull(sum(account_movements.debit), 0) < sum(td.value)')
    ->groupBy('transactions.id')
    ->select(DB::raw('max(transactions.id) as ID'),
    DB::raw('max(taxpayers.name) as Supplier'),
    DB::raw('max(taxpayers.taxid) as SupplierTaxID'),
    DB::raw('max(currencies.code) as Currency'),
    DB::raw('max(transactions.payment_condition) as PaymentCondition'),
    DB::raw('max(transactions.date) as Date'),
    DB::raw('DATE_ADD(max(transactions.date), INTERVAL max(transactions.payment_condition) DAY) as Expiry'),
    DB::raw('max(transactions.number) as Number'),
    DB::raw('ifnull(sum(account_movements.debit/account_movements.rate), 0) as Paid'),
    DB::raw('sum(td.value/transactions.rate) as Value'))
    ->orderByRaw('DATE_ADD(transactions.date, INTERVAL transactions.payment_condition DAY)', 'desc')
    ->orderBy('transactions.number', 'desc')
    ->skip($skip)
    ->take(100)
    ->get();

    return response()->json($transactions);
  }

  public function get_account_payableByID(Taxpayer $taxPayer, Cycle $cycle,$id)
  {
    $accountMovement = Transaction::MyPurchases()
    ->join('taxpayers', 'taxpayers.id', 'transactions.supplier_id')
    ->join('currencies', 'transactions.currency_id','currencies.id')
    ->join('transaction_details as td', 'td.transaction_id', 'transactions.id')
    ->leftJoin('account_movements', 'transactions.id', 'account_movements.transaction_id')
    ->where('transactions.customer_id', $taxPayer->id)
    ->where('transactions.id',$id)
    ->where('transactions.payment_condition', '>', 0)
    //->whereRaw('ifnull(sum(account_movements.debit), 0) < sum(td.value)')
    ->groupBy('transactions.id')
    ->select(DB::raw('max(transactions.id) as ID'),
    DB::raw('max(taxpayers.name) as Supplier'),
    DB::raw('max(taxpayers.taxid) as SupplierTaxID'),
    DB::raw('max(currencies.code) as Currency'),
    DB::raw('max(currencies.id) as CurrencyID'),
    DB::raw('max(transactions.payment_condition) as PaymentCondition'),
    DB::raw('max(transactions.date) as Date'),
    DB::raw('DATE_ADD(max(transactions.date), INTERVAL max(transactions.payment_condition) DAY) as Expiry'),
    DB::raw('max(transactions.number) as Number'),
    DB::raw('ifnull(sum(account_movements.debit/account_movements.rate), 0) as Paid'),
    DB::raw('sum(td.value/transactions.rate) as Value'))
    ->orderByRaw('DATE_ADD(transactions.date, INTERVAL transactions.payment_condition DAY)', 'desc')
    ->orderBy('transactions.number', 'desc')
    ->get();
    return response()->json($accountMovement);
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
  public function store(Request $request)
  {
    if ($request->payment_value > 0)
    {
      $accountMovement = new AccountMovement();
      $accountMovement->taxpayer_id = $request->taxpayer_id;
      $accountMovement->chart_id =$request->chart_id ;
      $accountMovement->date = $request->Date;

      $accountMovement->transaction_id = $request->ID != '' ? $request->ID : null;
      $accountMovement->currency_id = $request->CurrencyID;
      $accountMovement->rate = $request->rate;
      $accountMovement->debit = $request->payment_value != '' ? $request->payment_value : 0;
      $accountMovement->comment = $request->comment;

      $accountMovement->save();

      return response()->json('ok', 200);
    }
    return response()->json('no value', 403);
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\AccountMovement  $accountMovement
  * @return \Illuminate\Http\Response
  */
  public function show(AccountMovement $accountMovement)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\AccountMovement  $accountMovement
  * @return \Illuminate\Http\Response
  */
  public function edit(AccountMovement $accountMovement)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\AccountMovement  $accountMovement
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, AccountMovement $accountMovement)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\AccountMovement  $accountMovement
  * @return \Illuminate\Http\Response
  */
  public function destroy(AccountMovement $accountMovement)
  {
    //
  }
}
