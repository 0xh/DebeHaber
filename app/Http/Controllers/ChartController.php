<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Chart;
use App\Cycle;
use App\Enums\ChartTypeEnum;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Taxpayer $taxPayer, Cycle $cycle)
    {
        return view('accounting/chart');
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
    public function store(Request $request, Taxpayer $taxPayer, Cycle $cycle)
    {

        $chart = $request->id == 0 ? $chart = new Chart() : Chart::where('id', $request->id)->first();

        $chart->chart_version_id = $cycle->chart_version_id;
        $chart->country = $taxPayer->country;
        $chart->taxpayer_id = $taxPayer->id;

        if ($request->parent_id > 0)
        {
            $chart->parent_id = $request->parent_id;
        }

        if ($request->is_accountable == 'true')
        {
            $chart->is_accountable = 1;
            $chart->sub_type = $request->sub_type;
        }
        else
        {
            $chart->is_accountable = 0;
            $chart->sub_type = 0;
        }
        if ($request->type>0) {
            $chart->type = $request->type;
        }

        if ($request->coefficient > 0)
        {
            $chart->coefficient = $request->coefficient;

        }

        $chart->code = $request->code;
        $chart->name = $request->name;
        $chart->save();

        return response()->json(200);
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Chart  $chart
    * @return \Illuminate\Http\Response
    */
    public function show(Chart $chart)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Chart  $chart
    * @return \Illuminate\Http\Response
    */
    public function edit(Chart $chart)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Chart  $chart
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Chart $chart)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Chart  $chart
    * @return \Illuminate\Http\Response
    */
    public function destroy(Chart $chart)
    {
        //
    }


    // All API related Queries.

    public function getCharts(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::orderBy('code')->get();
        return response()->json($charts);
    }

    //
    public function getSalesAccounts(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::SalesAccounts()->orderBy('name')->get();
        return response()->json($charts);
    }

    // Accounts used in Purchase. Expense + Fixed Assets
    public function getPurchaseAccounts(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::PurchaseAccounts()->orderBy('name')->get();
        return response()->json($charts);
    }

    // Money Accounts
    public function getMoneyAccounts(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::MoneyAccounts()->orderBy('name')->get();
        return response()->json($charts);
    }

    // Debit VAT, used in Sales. Also Normal Sales Tax (Not VAT).
    public function getVATDebit(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::
        withoutGlobalScopes()
        ->My($taxPayer, $cycle)
        ->VATDebitAccounts()
        ->get();
        return response()->json($charts);
    }

    // Credit VAT, used in Purchases
    public function getVATCredit(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::withoutGlobalScopes()
        ->My($taxPayer, $cycle)
        ->VATCreditAccounts()
        ->get();
        return response()->json($charts);
    }

    // Improve with Elastic Search
    public function getParentAccount(Taxpayer $taxPayer, Cycle $cycle, $query)
    {
        $charts = Chart::where('is_accountable', false)
        ->where(function ($q) use ($query)
        {
            $q->where('name', 'like', '%' . $query . '%')
            ->orWhere('code', 'like', '%' . $query . '%');
        })
        ->with('children')
        ->get();

        return response()->json($charts);
    }
}
