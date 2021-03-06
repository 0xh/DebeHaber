<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\CycleBudget;
use App\Chart;
use App\Http\Resources\BalanceResource;
use DB;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index(Taxpayer $taxPayer, Cycle $cycle)
     {


         return view('accounting/budget');
     }

     public function getBudget(Taxpayer $taxPayer, Cycle $cycle)
     {
         //get the journals used as opening balance; is_first = true.
         $cycleBudgets = CycleBudget::where('cycle_id', $cycle->id)->get();

         //get list of charts.
         $charts =  Chart::My($taxPayer, $cycle)
         ->select('id', 'code', 'name',
         'type', 'sub_type', 'is_accountable',
         DB::raw('null as comment'),
         DB::raw('null as debit'),
         DB::raw('null as credit'),
         DB::raw('0 as delta'))
         ->orderBy('code')
         ->get();

         if (isset($cycleBudgets))
         {
             // Loop through Journal entries and add to chart balance
             foreach ($cycleBudgets->groupBy('chart_id') as $groupedBudgets)
             {
                 $chart = $charts->where('id', $groupedBudgets->first()->chart_id)->first();

                 if (isset($chart))
                 {
                     $chart->id = $groupedBudgets->first()->id;
                     $chart->debit = $groupedBudgets->sum('debit');
                     $chart->credit = $groupedBudgets->sum('credit');
                     $chart->comment = $groupedBudgets->first()->comment;
                 }
             }
         }

         $budget = $charts->sortBy('type')->sortBy('code');
         return response()->json(BalanceResource::collection($budget));
     }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Taxpayer $taxPayer, Cycle $cycle)
    {
        $details = collect($request)->where('is_accountable', '=', 1);

        foreach ($details as $detail)
        {
            // JournalDetail::where('id', $detail->journal_id)->first() ??
            $cycleBudget = CycleBudget::where('cycle_id',$cycle->id)->first() ?? new CycleBudget();;

            $cycleBudget->cycle_id = $cycle->id;
            $cycleBudget->chart_id = $detail['id'];
            $cycleBudget->debit = $detail['debit'] ?? 0;
            $cycleBudget->credit = $detail['credit'] ?? 0;
            $cycleBudget->comment = $detail['comment']??'';

            //Save only if there are values ot be saved. avoid saving blank values.
            if ($cycleBudget->debit > 0 || $cycleBudget->credit > 0)
            {
                $cycleBudget->save();
            }
        }

        return response()->json('Ok', 200);
    }
}
