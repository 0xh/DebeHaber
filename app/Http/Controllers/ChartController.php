<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Chart;
use App\Cycle;
use App\Enums\ChartTypeEnum;
use Illuminate\Http\Request;

class ChartController extends Controller
{
  /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function index(Taxpayer $taxPayer, Cycle $cycle)
  {
    return view('accounting/chart');
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
  public function store(Request $request, Taxpayer $taxPayer, Cycle $cycle)
  {
    $chart = $request->id == 0 ? $chart = new Chart() : Chart::where('id', $request->id)->first();
    $chart->chart_version_id = $cycle->chart_version_id;
    $chart->type = $request->type;
    $chart->sub_type = $request->sub_type;
    $chart->country = $taxPayer->country;
    if ($request->parent_id > 0)
    {
      $chart->parent_id = $request->parent_id;
    }

    $chart->is_accountable = $request->is_accountable == 'true' ? 1 : 0;
    $chart->code = $request->code;
    $chart->taxpayer_id = $taxPayer->id;
    $chart->name = $request->name;
    $chart->save();

    return response()->json('ok');
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Chart  $chart
  * @return \Illuminate\Http\Response
  */
  public function show(Chart $chart)
  {
    //
  }

  /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Chart  $chart
  * @return \Illuminate\Http\Response
  */
  public function edit(Chart $chart)
  {
    //
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  \App\Chart  $chart
  * @return \Illuminate\Http\Response
  */
  public function update(Request $request, Chart $chart)
  {
    //
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Chart  $chart
  * @return \Illuminate\Http\Response
  */
  public function destroy(Chart $chart)
  {
    //
  }

  public function get_chart(Taxpayer $taxPayer,Cycle $cycle)
  {

    $chart = Chart::where('charts.taxpayer_id', $taxPayer->id)
    ->join('chart_versions', 'charts.chart_version_id', 'chart_versions.id')
    ->select('charts.id',
    'charts.country',
    'charts.is_accountable',
    'charts.code',
    'charts.name','charts.level',
    'charts.type as type',
    'charts.sub_type',
    'chart_versions.name as chart_version_name',
    'chart_versions.id as chart_version_id')
    ->get();

    return response()->json($chart);
  }

  public function get_item(Taxpayer $taxPayer,Cycle $cycle)
  {

    $chart = Chart::join('chart_versions', 'charts.chart_version_id', 'chart_versions.id')
    ->where('charts.type', 1)
    ->where('charts.sub_type', 8)
    ->select('charts.id',
    'charts.country',
    'charts.is_accountable',
    'charts.code',
    'charts.name',
    'charts.level',
    'charts.type as type',
    'charts.sub_type',
    'chart_versions.name as chart_version_name',
    'chart_versions.id as chart_version_id')
    ->get();

    return response()->json($chart);
  }

  public function get_account(Taxpayer $taxPayer, Cycle $cycle)
  {
    $chart = Chart::join('chart_versions', 'charts.chart_version_id', 'chart_versions.id')
    ->where('charts.type', 1)
    ->where('charts.sub_type', 1)
    ->orWhere('charts.sub_type', 3)
    ->select('charts.id',
    'charts.country',
    'charts.is_accountable',
    'charts.code',
    'charts.name',
    'charts.level',
    'charts.type as type',
    'charts.sub_type',
    'chart_versions.name as chart_version_name',
    'chart_versions.id as chart_version_id')
    ->get();

    return response()->json($chart);
  }
  public function get_Parentaccount(Taxpayer $taxPayer, Cycle $cycle,$frase)
  {
    $chart = Chart::join('chart_versions', 'charts.chart_version_id', 'chart_versions.id')
    ->where('is_accountable',0)
    ->where('charts.name', 'LIKE', "%$frase%")
    ->orwhere('charts.code', 'LIKE', "$frase%")

    ->select('charts.id',
    'charts.country',
    'charts.is_accountable',
    'charts.code',
    'charts.name',
    'charts.level',
    'charts.type as type',
    'charts.sub_type',
    'chart_versions.name as chart_version_name',
    'chart_versions.id as chart_version_id')
    ->get();

    return response()->json($chart);
  }

  public function get_tax(Taxpayer $taxPayer,Cycle $cycle)
  {
    $chart = Chart::join('chart_versions', 'charts.chart_version_id', 'chart_versions.id')
    ->where('charts.type', 1)
    ->where('charts.sub_type', 12)
    ->select('charts.id',
    'charts.country',
    'charts.is_accountable',
    'charts.code',
    'charts.name',
    'charts.level',
    'charts.type as type',
    'charts.sub_type',
    'chart_versions.name as chart_version_name',
    'chart_versions.id as chart_version_id')
    ->get();

    return response()->json($chart);
  }
}
