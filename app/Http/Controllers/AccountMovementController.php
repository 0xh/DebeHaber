<?php

namespace App\Http\Controllers;


use App\AccountMovement;
use App\TaxPayer;
use App\Cycle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use DB;
use Auth;

class AccountMovementController extends Controller
{
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        return view('commercial/money-movements');
    }
    public function GetMovement(Taxpayer $taxPayer, Cycle $cycle,$skip)
    {
        $movements = AccountMovement::where('taxpayer_id',$taxPayer->id)
        ->with('chart')
        ->with('transaction')
        ->skip($skip)
        ->take(300)
        ->get();;

        return response()->json($movements);
    }
}
