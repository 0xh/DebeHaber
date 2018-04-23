<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\Chart;
use App\Inventory;
use Illuminate\Http\Request;

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
            $inventory = new Inventory();
        }
        else
        {
            $inventory = Inventory::where('id', $request->id)->first();
        }

        $inventory->taxpayer_id = $request->taxpayer_id;
        $inventory->chart_id =$taxPayer->chart_id ;
        $inventory->date = $request->date;
        $inventory->current_value = $request->current_value;

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
