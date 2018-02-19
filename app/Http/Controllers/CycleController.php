<?php

namespace App\Http\Controllers;

use App\Cycle;
use Illuminate\Http\Request;

class CycleController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        return view('accounting/cycle/index');
    }

    public function get_cycle()
    {
        $Cycle = Cycle::
        Join('chart_versions', 'cycles.chart_version_id', 'chart_versions.id')
        ->select('cycles.id','cycles.year','cycles.start_date','cycles.end_date'
        ,'chart_versions.name as chart_version_name','chart_versions.id as chart_version_id')
        ->get();

        return response()->json($Cycle);
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

        if ($request->id==0) {
            $Cycle= new Cycle();

        }
        else {
            $Cycle= Cycle::where('id',$request->id)->first();

        }
        $Cycle->chart_version_id=$request->chart_version_id;
        $Cycle->year=$request->year;
        $Cycle->start_date=$request->start_date;
        $Cycle->end_date=$request->end_date;
        $Cycle->save();
        return response()->json('ok');
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
