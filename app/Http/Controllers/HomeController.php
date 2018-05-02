<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TaxpayerIntegration;
use Auth;

class HomeController extends Controller
{
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show the application dashboard.
    *
    * @return Response
    */
    public function show()
    {
        $user = Auth()->user();

        $taxPayerIntegrations = TaxpayerIntegration::MyTaxPayers($user->current_team->id)
        ->where('status', 2)
        ->with('taxpayer')
        ->get();

        $integrationInvites = TaxpayerIntegration::
        where('is_owner', 0)
        ->where('status', 1)
        ->whereIn('taxpayer_id', $taxPayerIntegrations->where('is_owner', 1))
        ->with(['taxpayer', 'team'])
        ->get();

        return view('home')
        ->with('taxPayerIntegrations', $taxPayerIntegrations)
        ->with('integrationInvites', $integrationInvites);
    }
}
