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

        if (isset($user) == false)
        {
            return view('welcome');
        }

        $taxPayerIntegrations = TaxpayerIntegration::MyTaxPayers($user->current_team->id)
        ->whereIn('status', [1, 2])
        ->with('taxpayer')
        ->with('taxpayer.setting')
        ->get();

        $integrationInvites = TaxpayerIntegration::
        where('is_owner', 0)
        ->where('status', 1)
        ->whereIn('taxpayer_id', $taxPayerIntegrations->where('is_owner', '=', 1)->pluck('taxpayer_id'))
        ->with(['taxpayer', 'team'])
        ->get();

        return view('home')
        ->with('taxPayerIntegrations', $taxPayerIntegrations)
        ->with('integrationInvites', $integrationInvites);
    }

    public function teamAccept($integrationID, $type)
    {
        $integrationInvite = TaxpayerIntegration::find($integrationID);

        if (isset($integrationInvite))
        {
            $integrationInvite->status = 2;
            $integrationInvite->type = $type;
            $integrationInvite->save();
        }

        return redirect()->back();
    }

    //Accept a Member
    public function teamReject($integrationID)
    {
        $integrationInvite = TaxpayerIntegration::find($integrationID);

        if (isset($integrationInvite))
        {
            $integrationInvite->status = 3;
            $integrationInvite->save();
        }

        return redirect()->back();
    }
}
