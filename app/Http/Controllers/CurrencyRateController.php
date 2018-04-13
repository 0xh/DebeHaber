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

    public function get_buyRateByCurrency($taxPayer, $id, $date)
    {
        $date = $date ?? Carbon::now();

        $currencyRate = CurrencyRate::where('currency_id', $id)
        ->whereDate('date', Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'))
        ->first();

        if (isset($currencyRate))
        { return response()->json($currencyRate->buy_rate); }

        return response()->json('Error', 500);
    }

    public function get_sellRateByCurrency($taxPayer, $id, $date)
    {
        $date = $date ?? Carbon::now();

        $currencyRate = CurrencyRate::where('currency_id', $id)
        ->whereDate('date', Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'))
        ->first();

        if (isset($currencyRate))
        { return response()->json($currencyRate->sell_rate); }

        return response()->json('Error', 500);
    }

    public function get_Allrate()
    {
        $currencyRate = CurrencyRate::Join('currencies', 'currencies.id', 'currency_rates.currency_id')
        ->select(DB::raw('currencies.name, rate'))
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
        $currencyrate->rate = $request->rate;

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
