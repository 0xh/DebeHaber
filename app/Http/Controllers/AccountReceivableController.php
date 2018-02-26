<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\AccountMovement;
use Illuminate\Http\Request;

class AccountReceivableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
          return view('/accounting/account-receivables');
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
      $accountMovement->chart_id =$taxPayer->chart_id ;
      $accountMovement->date = $request->date;
      $accountMovement->transaction_id = $request->transaction_id;
      $accountMovement->currency_id = $request->currency_id;
      $accountMovement->rate = $request->rate;
      $accountMovement->debit = $request->debit;
      $accountMovement->credit = $request->credit;
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
