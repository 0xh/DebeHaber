<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\Transaction;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        return view('/commercial/purchases');
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
    public function store(Request $request,Taxpayer $taxPayer)
    {
        if ($request->id == 0)
        {
            $Transaction = new Transaction();
        }
        else
        {
            $Transaction = Transaction::where('id', $request->id)->first();
        }

        $Transaction->customer_id = $request->customer_id;
        $Transaction->supplier_id = $taxPayer->id;
        $Transaction->document_id = $request->document_id;
        $Transaction->currency_id = $request->currency_id;
        $Transaction->rate = $request->rate;
        $Transaction->payment_condition = $request->payment_condition;
        $Transaction->chart_account_id = $request->chart_account_id;
        $Transaction->date = $request->date;
        $Transaction->number = $request->number;
        $Transaction->code = $request->code;
        $Transaction->code_expiry = $request->code_expiry;
        $Transaction->comment = $request->comment;
        $Transaction->ref_id = $request->ref_id;
        $Transaction->type = $request->type;
        $Transaction->save();

        foreach ($request->details as $detail)
        {
            if ($request->id == 0)
            {
                $TransactionDetail = new TransactionDetail();
            }
            else
            {
                $TransactionDetail = TransactionDetail::where('id',$request->id)->first();
            }

            $TransactionDetail->transaction_id = $Transaction->id;
            $TransactionDetail->chart_id = $detail['chart_id'];
            $TransactionDetail->chart_vat_id = $detail['chart_vat_id'];
            $TransactionDetail->value = $detail['value'];
            $TransactionDetail->save();
        }
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Transaction  $transaction
    * @return \Illuminate\Http\Response
    */
    public function show(Transaction $transaction)
    {
        //
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
    public function destroy(Transaction $transaction)
    {
        //
    }
}
