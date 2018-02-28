<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        //
    }
    public function get_document(Taxpayer $taxPayer,$type)
    {
        $Document=Document::where('type',$type)->where('taxpayer_id',$taxPayer->id)->get();

        return response()->json($Document);
    }
    public function get_documentByID(Taxpayer $taxPayer,$id)
    {
        $Document=Document::where('id',$id)->first();

        return response()->json($Document);
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
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Document  $document
    * @return \Illuminate\Http\Response
    */
    public function show(Document $document)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Document  $document
    * @return \Illuminate\Http\Response
    */
    public function edit(Document $document)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Document  $document
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Document  $document
    * @return \Illuminate\Http\Response
    */
    public function destroy(Document $document)
    {
        //
    }
}
