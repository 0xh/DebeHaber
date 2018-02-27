<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\AccountMovement;
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

    public function get_account_receivable($taxPayerID)
    {
        $accountMovement = AccountMovement::
        Join('charts', 'charts.id', 'account_movements.chart_id')
        ->leftJoin('currencies', 'currencies.id', 'account_movements.currency_id')
        ->where('account_movements.taxpayer_id', $taxPayerID)
          ->where('credit','>',0)
        ->select(DB::raw('false as selected,account_movements.id,charts.name as chart
        ,transaction_id,currencies.name as currency,currency_id,rate,debit,credit,date
        '))
        ->get();
        return response()->json($accountMovement);
    }
    public function get_account_receivableByID($taxPayerID,$id)
    {
        $accountMovement = AccountMovement::
        Join('charts', 'charts.id', 'account_movements.chart_id')
        ->leftJoin('currencies', 'currencies.id', 'account_movements.currency_id')
        ->where('account_movements.taxpayer_id', $taxPayerID)
        ->where('account_movements.id',$id)
        ->select(DB::raw('false as selected,account_movements.id,charts.name as chart,chart_id
        ,transaction_id,currencies.name as currency,currency_id,rate,debit,credit,date
        '))
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
      if ($request->id == 0)
      {
        $accountMovement = new AccountMovement();
      }
      else
      {
        $accountMovement = AccountMovement::where('id', $request->id)->first();
      }

      $accountMovement->taxpayer_id = $request->taxpayer_id;
      $accountMovement->chart_id =$request->chart_id ;
      $accountMovement->date = $request->date;

      $accountMovement->transaction_id = $request->transaction_id!=''?$request->transaction_id:null;
      $accountMovement->currency_id = $request->currency_id;
      $accountMovement->rate = $request->rate;
      $accountMovement->debit = $request->debit!=''?$request->debit:0;
      $accountMovement->credit = $request->credit!=''?$request->credit:0;
      $accountMovement->comment = $request->comment;

      $accountMovement->save();

      return response()->json('ok');
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
