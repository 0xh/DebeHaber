<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\ChartVersion;
use App\Cycle;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TaxpayerController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {

    }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('taxpayer/profile');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //Check if taxPayer exists.
        $taxPayer = $request->id == 0 ? new Taxpayer() : Taxpayer::where('id',$request->id)->first();

        //Country from Selection Box
        $taxPayer->code = $request->code;
        $taxPayer->taxid = $request->taxid;
        $taxPayer->name = $request->name;
        $taxPayer->alias = $request->alias;
        $taxPayer->address = $request->address;
        $taxPayer->telephone = $request->telephone;
        $taxPayer->email = $request->email;

        $taxPayer->save();

        if ($request->id == 0)
        {
            $current_date = Carbon::now();

            //Check if Default Version is available for Country.
            $chartVersion = new ChartVersion();
            $chartVersion->name = $current_date->year;
            $chartVersion->taxpayer_id = $taxPayer->id;
            $chartVersion->save();

            $Cycle = new Cycle();
            $Cycle->chart_version_id = $chartVersion->id;
            $Cycle->year = $current_date->year;
            $Cycle->start_date = new Carbon('first day of January');
            $Cycle->end_date = new Carbon('last day of December');
            $Cycle->taxpayer_id = $taxPayer->id;
            $Cycle->save();
        }

        return response()->view(201);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function show(Taxpayer $taxpayer)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function edit(Taxpayer $taxpayer)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Taxpayer $taxpayer)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function destroy(Taxpayer $taxpayer)
    {
        //
    }
}
