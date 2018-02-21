<?php

namespace App\Http\Controllers;

use App\Chart;
use App\Enums\ChartTypeEnum;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('accounting/chart');
    }

    public function get_chart($teamID)
    {

        $Chart=Chart::where('charts.taxpayer_id',$teamID)->
        Join('chart_versions', 'charts.chart_version_id', 'chart_versions.id')
        ->select('charts.id','charts.country','charts.is_accountable','charts.code',
        'charts.name','charts.level','charts.type','charts.sub_type'
        ,'chart_versions.name as chart_version_name','chart_versions.id as chart_version_id')
        ->get();
        return response()->json($Chart);
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
    public function store(Request $request,$taxpayer)
    {
        if ($request->id==0) {
            $Chart= new Chart();

        }
        else {
            $Chart= Chart::where('id',$request->id)->first();

        }
        $Chart->chart_version_id=$request->chart_version_id;
        $Chart->country=$request->country;

        $Chart->is_accountable=$request->is_accountable == 'true'?1:0 ;
        $Chart->code=$request->code;
        $Chart->taxpayer_id=$taxpayer;
        $Chart->name=$request->name;
        // $Chart->level=$request->level;
        //$Chart->type=$request->type;
        //$Chart->sub_type=$request->sub_type;
        $Chart->save();
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
}
