<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\Chart;
use App\Inventory;
use App\Transaction;
use App\Journal;
use Illuminate\Http\Request;
use DB;
class InventoryController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts=Chart::Inventories()->get();

        return view('commercial/inventory')->with('charts',$charts);
    }

    public function getInventories(Taxpayer $taxPayer, Cycle $cycle,$skip)
    {
        $inventory = Inventory::skip($skip)
        ->take(100)
        ->get();
        return response()->json($inventory);
    }

    public function get_inventory($taxPayerID)
    {
        $Transaction = Inventory::where('taxpayer_id', $taxPayerID)->get();
        return response()->json($Transaction);
    }

    public function get_InventoryChartType(Taxpayer $taxPayer, Cycle $cycle)
    {
        $Transaction = Chart::where('chart_version_id', $cycle->chart_version_id)
        ->where('type',4)
        ->where('sub_type',4)
        ->get();

        return response()->json($Transaction);
    }
    public function Calulate_sales(Request $request,Taxpayer $taxPayer, Cycle $cycle)
    {

        $Transaction =Transaction::MySales()
        ->leftJoin('transaction_details as td', 'td.transaction_id', 'transactions.id')
        ->whereIn('td.chart_id',$request->selectcharttype)
        ->groupBy('td.chart_id')
        ->select(DB::raw('sum(td.value) as sales_cost'),
        DB::raw('sum(td.cost) as cost_value'))
        ->get();
        return response()->json($Transaction);
    }
    public function Calulate_InvenotryValue(Request $request,Taxpayer $taxPayer, Cycle $cycle)
    {
        $journals =Journal::leftJoin('journal_details as jd', 'jd.journal_id', 'journals.id')
        ->where('journals.cycle_id',$cycle->id)
        ->where('jd.chart_id',$request->chart_id)
        ->groupBy('jd.chart_id')
        ->select(DB::raw('sum(td.debit) as inventory_value'))
        ->get();
        return response()->json($journals);
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
        if ($request->id == 0)
        {
            $inventory = new Inventory();
        }
        else
        {
            $inventory = Inventory::where('id', $request->id)->first();
        }

        $inventory->taxpayer_id = $taxPayer->id;
        $inventory->chart_id =$request->chart_id ;
        $inventory->start_date = $request->start_date;
        $inventory->end_date = $request->end_date;
        $inventory->sales_value = $request->sales_value;
        $inventory->cost_value = $request->cost_value;
        $inventory->inventory_value = $request->inventory_value;
        $inventory->chart_of_incomes =implode(' ', $request->selectcharttype) ;
        $inventory->comments = 'abc';

        $inventory->save();

        return response()->json('ok');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Inventory  $inventory
    * @return \Illuminate\Http\Response
    */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Inventory  $inventory
    * @return \Illuminate\Http\Response
    */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Inventory  $inventory
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Inventory  $inventory
    * @return \Illuminate\Http\Response
    */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
