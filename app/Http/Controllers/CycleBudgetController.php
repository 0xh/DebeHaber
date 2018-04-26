<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\CycleBudget;
use Illuminate\Http\Request;
use DB;

class CycleBudgetController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        //
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
        //
    }
    public function cyclebudgetstore(Request $request,Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = collect($request);

        foreach ($charts as $detail)
        {
            $cyclebudget = new CycleBudget() ;
            $cyclebudget->cycle_id = $cycle->id;
            $cyclebudget->chart_id = $detail['id'];
            $cyclebudget->debit = $detail['debit'];
            $cyclebudget->credit = $detail['credit'];
            $cyclebudget->comment = $cycle->year - ' Budget';
            $cyclebudget->save();
        }

        return response()->json('ok', 200);

    }
    public function getCycleBudgetsByCycleID (Request $request,Taxpayer $taxPayer, Cycle $cycle,$id)
    {
        $cyclebudget = CycleBudget::
        join('charts', 'cycle_budgets.chart_id','charts.id')
        ->select('charts.id',
        'charts.code',
        'charts.name',
        'debit',
        'credit')
        ->get();

        return response()->json($cyclebudget);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\CycleBudget  $cycleBudget
    * @return \Illuminate\Http\Response
    */
    public function show(CycleBudget $cycleBudget)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\CycleBudget  $cycleBudget
    * @return \Illuminate\Http\Response
    */
    public function edit(CycleBudget $cycleBudget)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\CycleBudget  $cycleBudget
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, CycleBudget $cycleBudget)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\CycleBudget  $cycleBudget
    * @return \Illuminate\Http\Response
    */
    public function destroy(CycleBudget $cycleBudget)
    {
        //
    }
}
