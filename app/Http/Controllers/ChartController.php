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
    public function store(Request $request, $taxPayerID)
    {
        $chart = $request->id == 0 ? $chart = new Chart() : Chart::where('id', $request->id)->first();
        $chart->chart_version_id = $request->chart_version_id;
        $chart->country = $request->country;

        $chart->is_accountable = $request->is_accountable == 'true' ? 1 : 0;
        $chart->code = $request->code;
        $chart->taxpayer_id = $taxPayerID;
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

    public function get_chart($taxPayerID)
    {
        $chart = Chart::where('charts.taxpayer_id', $taxPayerID)
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

    public function get_product($taxPayerID)
    {
        $chart = Chart::where('charts.taxpayer_id', $taxPayerID)
        ->where('charts.type', 1)
        ->where('charts.sub_type', 8)
        ->Join('chart_versions', 'charts.chart_version_id', 'chart_versions.id')
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

    public function get_account($taxPayerID)
    {
        $chart = Chart::where('charts.taxpayer_id', $taxPayerID)->where('charts.type', 1)
        ->where('charts.sub_type', 1)
        ->orwhere('charts.sub_type', 3)
        ->Join('chart_versions', 'charts.chart_version_id', 'chart_versions.id')
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

    public function get_tax($taxPayerID)
    {
        $chart = Chart::where('charts.taxpayer_id', $taxPayerID)
        ->where('charts.type', 1)
        ->where('charts.sub_type', 12)
        ->join('chart_versions', 'charts.chart_version_id', 'chart_versions.id')
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
