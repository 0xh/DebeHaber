<?php

namespace App\Http\Controllers;

use App\AccountMovement;
use App\JournalTransaction;
use App\Transaction;
use App\Taxpayer;
use App\Cycle;
use Illuminate\Http\Request;
use DB;

class AccountReceivableController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        return view('/commercial/accounts-receivable');
    }

    public function get_account_receivable(Taxpayer $taxPayer, Cycle $cycle, $skip)
    {
        $transactions = Transaction::MySales()
        ->join('taxpayers', 'taxpayers.id', 'transactions.customer_id')
        ->join('currencies', 'transactions.currency_id','currencies.id')
        ->join('transaction_details as td', 'td.transaction_id', 'transactions.id')
        ->leftJoin('account_movements', 'transactions.id', 'account_movements.transaction_id')
        ->where('transactions.supplier_id', $taxPayer->id)
        ->where('transactions.payment_condition', '>', 0)
        ->whereBetween('date', [$cycle->start_date, $cycle->end_date])
        ->groupBy('transactions.id')
        ->select(DB::raw('max(transactions.id) as ID'),
        DB::raw('max(taxpayers.name) as Customer'),
        DB::raw('max(taxpayers.taxid) as CutomerTaxID'),
        DB::raw('max(currencies.code) as Currency'),
        DB::raw('max(transactions.payment_condition) as PaymentCondition'),
        DB::raw('max(transactions.date) as Date'),
        DB::raw('DATE_ADD(max(transactions.date), INTERVAL max(transactions.payment_condition) DAY) as Expiry'),
        DB::raw('max(transactions.number) as Number'),
        DB::raw('ifnull(sum(account_movements.credit / account_movements.rate), 0) as Paid'),
        DB::raw('sum(td.value/transactions.rate) as Value'))
        ->orderByRaw('DATE_ADD(max(transactions.date), INTERVAL max(transactions.payment_condition) DAY)', 'desc')
        ->orderByRaw('max(transactions.number)', 'desc')
        ->skip($skip)
        ->take(100)
        ->get();

        return response()->json($transactions);
    }

    public function get_account_receivableByID(Taxpayer $taxPayer, Cycle $cycle,$id)
    {
        $accountMovement =   $transactions = Transaction::MySales()
        ->join('taxpayers', 'taxpayers.id', 'transactions.customer_id')
        ->join('currencies', 'transactions.currency_id','currencies.id')
        ->join('transaction_details as td', 'td.transaction_id', 'transactions.id')
        ->leftJoin('account_movements', 'transactions.id', 'account_movements.transaction_id')
        ->where('transactions.supplier_id', $taxPayer->id)
        ->where('transactions.payment_condition', '>', 0)
        ->where('transactions.id',$id)
        ->groupBy('transactions.id')
        ->select(DB::raw('max(transactions.id) as ID'),
        DB::raw('max(taxpayers.name) as Customer'),
        DB::raw('max(taxpayers.taxid) as CutomerTaxID'),
        DB::raw('max(currencies.code) as Currency'),
        DB::raw('max(transactions.payment_condition) as PaymentCondition'),
        DB::raw('max(transactions.date) as Date'),
        DB::raw('max(currencies.id) as CurrencyID'),
        DB::raw('DATE_ADD(max(transactions.date), INTERVAL max(transactions.payment_condition) DAY) as Expiry'),
        DB::raw('max(transactions.number) as Number'),
        DB::raw('ifnull(sum(account_movements.debit/account_movements.rate), 0) as Paid'),
        DB::raw('sum(td.value/transactions.rate) as Value'))
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
            $accountMovement->credit = $request->payment_value != '' ? $request->payment_value : 0;
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
}
