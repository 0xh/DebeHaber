<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\TaxpayerIntegration;
use App\ChartVersion;
use App\Cycle;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
    public function get_taxpayer($teamID)
    {

        $taxPayer = taxPayer::where('id',$teamID)->first();

        if (isset($taxPayer))
        {
            $taxPayers = taxPayer::select('name')->get();
            return response()->json($taxPayers);
        }

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

            $taxpayerIntegration = new taxpayerIntegration();
            $taxpayerIntegration->taxpayer_id = $taxPayer->id;
            $taxpayerIntegration->team_id = Auth::user()->current_team_id;
            $taxpayerIntegration->type = 1;
            $taxpayerIntegration->is_owner = 1;
            $taxpayerIntegration->is_company = 1;
            $taxpayerIntegration->save();

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

        return response()->json('ok');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function show(Taxpayer $taxPayer)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function edit(Taxpayer $taxPayer)
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
    public function update(Request $request, Taxpayer $taxPayer)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function destroy(Taxpayer $taxPayer)
    {
        //
    }

    public function showDashboard(Taxpayer $taxPayer)
    {
        return view('taxpayer/dashboard');
    }

    public function selectTaxpayer(Taxpayer $taxPayer)
    {
        //run code to check for fiscal year selection and create if not.
        return redirect()->route('taxpayer.dashboard', $taxPayer);
    }
}
