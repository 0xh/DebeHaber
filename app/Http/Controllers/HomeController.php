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
        ->with('taxpayer')
        ->get();

        return view('home')->with('taxPayerIntegrations', $taxPayerIntegrations);
    }
}
