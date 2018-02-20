<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use Illuminate\Http\Request;

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
    return view('taxpayer/taxpayer');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {

    if ($request->id==0) {
      $Taxpayer= new Taxpayer();

    }
    else {
      $Taxpayer= Taxpayer::where('id',$request->id)->first();

    }

    $Taxpayer->country=1;
    $Taxpayer->code=$request->code;
    $Taxpayer->name=$request->name;
    $Taxpayer->alias=$request->alias;
    $Taxpayer->email=$request->email;
    $Taxpayer->save();

    if ($request->id==0)
    {
      $current_date = Carbon::now();
      $ChartVersion= new ChartVersion();
      $ChartVersion->name=$current_date->year;
      $ChartVersion->taxpayer_id = $Taxpayer->id;
      $ChartVersion->save();
      $Cycle= new Cycle();
      $Cycle->year = $current_date->year;
      $Cycle->start_date = new Carbon('first day of January');
      $Cycle->end_date = new Carbon('last day of December');
      $Cycle->taxpayer_id = $Taxpayer->id;
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
