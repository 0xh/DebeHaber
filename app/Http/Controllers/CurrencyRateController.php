<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\CurrencyRate;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class CurrencyRateController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        return view('/configs/currencies/list');
    }

    public function get_ratesByCurrency($taxPayerID, $currencyID, $date)
    {
        $date = Carbon::parse($date) ?? Carbon::now();

        $currencyRate = CurrencyRate::whereDate('date', $date)
        ->where('currency_id', $currencyID)
        ->orWhere('taxpayer_id', $taxPayerID)
        ->orderBy('taxpayer_id')
        ->first();

        if (isset($currencyRate))
        {
            return response()->json($currencyRate);
        }
        else
        {
            //swap fx
            $currCode = Currency::where('id', $currencyID)->select('code');
            $currCompanyCode = $taxPayer->currency;
            $rate = Swap::historical($currCode . '/' . $currCompanyCode, $date);

            $currencyRate = new CurrencyRate();
            $currencyRate->date = $date;
            $currencyRate->currency_id = $currencyID;
            $currencyRate->buy_rate = $rate;
            $currencyRate->sell_rate = $rate;
            $currencyRate->save();

            return response()->json($currencyRate);
        }

        return response()->json(1);
    }

    public function get_Allrate()
    {
        $currencyRate = CurrencyRate::with('currency')
        ->get();

        return response()->json($currencyRate);
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
        $currencyrate = $request->id == 0 ? $currencyrate = new CurrencyRate() : CurrencyRate::where('id', $request->id)->first();

        $currencyrate->currency_id = $request->currency_id;
        $currencyrate->buy_rate = $request->buy_rate;
        $currencyrate->sell_rate = $request->sell_rate;
        $currencyrate->save();

        return response()->json('ok');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\CurrencyRate  $currencyRate
    * @return \Illuminate\Http\Response
    */
    public function show(CurrencyRate $currencyRate)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\CurrencyRate  $currencyRate
    * @return \Illuminate\Http\Response
    */
    public function edit(CurrencyRate $currencyRate)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\CurrencyRate  $currencyRate
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, CurrencyRate $currencyRate)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\CurrencyRate  $currencyRate
    * @return \Illuminate\Http\Response
    */
    public function destroy(CurrencyRate $currencyRate)
    {
        //
    }
}
