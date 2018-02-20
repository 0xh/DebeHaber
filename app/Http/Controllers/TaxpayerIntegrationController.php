<?php

namespace App\Http\Controllers;

use App\TaxpayerIntegration;
use Illuminate\Http\Request;

class TaxpayerIntegrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($teamID, $userID)
    {
        $taxPayerIntegration = TaxpayerIntegration::MyTaxPayers($teamID)
        ->join('taxpayers', 'taxpayers.id', 'taxpayer_integrations.taxpayer_id')
        ->leftJoin('taxpayer_favs', 'taxpayer_favs.taxpayer_id', 'taxpayers.id')
        ->select('taxpayer_integrations.taxpayer_id as id',
        'taxpayers.country',
        'taxpayers.name',
        'taxpayers.alias',
        'taxpayers.taxid',
        'taxpayer_favs.id as is_favorite')
        ->get();

        return $taxPayerIntegration;
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
     * @param  \App\TaxpayerIntegration  $taxpayerIntegration
     * @return \Illuminate\Http\Response
     */
    public function show(TaxpayerIntegration $taxpayerIntegration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TaxpayerIntegration  $taxpayerIntegration
     * @return \Illuminate\Http\Response
     */
    public function edit(TaxpayerIntegration $taxpayerIntegration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TaxpayerIntegration  $taxpayerIntegration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TaxpayerIntegration $taxpayerIntegration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TaxpayerIntegration  $taxpayerIntegration
     * @return \Illuminate\Http\Response
     */
    public function destroy(TaxpayerIntegration $taxpayerIntegration)
    {
        //
    }
}
