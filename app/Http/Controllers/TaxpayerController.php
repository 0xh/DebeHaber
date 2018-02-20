<?php

namespace App\Http\Controllers;

use App\Taxpayer;
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
