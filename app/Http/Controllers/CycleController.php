<?php

namespace App\Http\Controllers;

use App\ChartVersion;
use App\Taxpayer;
use App\Cycle;
use App\Chart;
use Illuminate\Http\Request;
use DB;

class CycleController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Taxpayer $taxPayer, Cycle $cycle)
  {
    $cycles = Cycle::where('cycles.taxpayer_id', $taxPayer->id)
    ->join('chart_versions', 'cycles.chart_version_id', 'chart_versions.id')
    ->select('cycles.id',
    'cycles.year',
    'cycles.start_date',
    'cycles.end_date',
    'chart_versions.name as chart_version_name',
    'chart_versions.id as chart_version_id')
    ->get();

    $versions = ChartVersion::My($taxPayer)->get();
    $charts = Chart::where('is_accountable',1)->
    select(DB::raw('id'),
    DB::raw('code'),
    DB::raw('name'),
    DB::raw('0 as debit'),
    DB::raw('0 as credit'))
    ->get();

    return view('accounting/cycles')
    ->with('cycles', $cycles)
    ->with('versions', $versions)
    ->with('charts', $charts);
  }

  public function get_cycle($taxPayerID)
  {
    $cycle = Cycle::where('cycles.taxpayer_id', $taxPayerID)
    ->join('chart_versions', 'cycles.chart_version_id', 'chart_versions.id')
    ->select('cycles.id',
    'cycles.year',
    'cycles.start_date',
    'cycles.end_date',
    'chart_versions.name as chart_version_name',
    'chart_versions.id as chart_version_id')
    ->get();

    return response()->json($cycle);
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
  public function store(Request $request,Taxpayer $taxPayer, Cycle $cycle)
  {
    if ($request->id == 0)
    {
      $cycle = new Cycle();
      $cycle->taxpayer_id = $taxPayer->id;
    }
    else
    {
      $cycle = Cycle::find($request->id) ?? null;
    }

    if ($cycle != null)
    {
      $cycle->chart_version_id = $request->chart_version_id;
      $cycle->year = $request->year;
      $cycle->start_date = $request->start_date;
      $cycle->end_date = $request->end_date;
      $cycle->save();

      return response()->json('ok', 200);
    }
  }



  /**
  * Display the specified resource.
  *
  * @param  \App\Cycle  $cycle
  * @return \Illuminate\Http\Response
  */
  public function show(Cycle $cycle)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Cycle  $cycle
  * @return \Illuminate\Http\Response
  */
  public function edit(Cycle $cycle)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Cycle  $cycle
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Cycle $cycle)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Cycle  $cycle
  * @return \Illuminate\Http\Response
  */
  public function destroy(Cycle $cycle)
  {
    //
  }
}
