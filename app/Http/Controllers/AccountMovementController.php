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
    public function store(Request $request,Taxpayer $taxPayer, Cycle $cycle)
    {
        if ($request->type!=2) {


            $accountMovement = new AccountMovement();
            $accountMovement->taxpayer_id = $request->taxpayer_id;
            $accountMovement->chart_id = $request->from_chart_id ;
            $accountMovement->date =  Carbon::now();;
            if ($request->type==0)
            {
                $accountMovement->debit = $request->debit != '' ? $request->debit : 0;
            }
            else
            {
                $accountMovement->credit = $request->credit != '' ? $request->credit : 0;
            }

            $accountMovement->currency_id = $request->currency_id;
            $accountMovement->rate = 1;

            $accountMovement->comment = $request->comment;

            $accountMovement->save();
        }
        else {
            $fromAccountMovement = new AccountMovement();
            $fromAccountMovement->taxpayer_id = $request->taxpayer_id;
            $fromAccountMovement->chart_id = $request->from_chart_id ;
            $fromAccountMovement->date =  Carbon::now();;
            $fromAccountMovement->debit = $request->debit != '' ? $request->debit : 0;
            $fromAccountMovement->currency_id = $request->currency_id;
            $fromAccountMovement->rate = 1;
            $fromAccountMovement->comment = $request->comment;
            $fromAccountMovement->save();

            $toAccountMovement = new AccountMovement();
            $toAccountMovement->taxpayer_id = $request->taxpayer_id;
            $toAccountMovement->chart_id = $request->to_chart_id ;
            $toAccountMovement->date =  Carbon::now();;
            $toAccountMovement->credit = $request->credit != '' ? $request->credit : 0;
            $toAccountMovement->currency_id = $request->currency_id;
            $toAccountMovement->rate = 1;
            $toAccountMovement->comment = $request->comment;
            $toAccountMovement->save();
        }

        return response()->json('ok', 200);
    }
}
