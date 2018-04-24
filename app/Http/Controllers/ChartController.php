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
        if ($request->asset_years > 0)
        {
            $chart->asset_years = $request->asset_years;

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
    public function getCharts(Taxpayer $taxPayer, Cycle $cycle,$skip)
    {
        $charts = Chart::orderBy('code')
        ->skip($skip)
        ->take(100)
        ->get();
        return response()->json($charts);
    }

    public function getChartsByID(Taxpayer $taxPayer, Cycle $cycle, $id)
    {
        $charts = Chart::where('id',$id)->get();
        return response()->json($charts, 200);
    }

    public function getAccountableCharts(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::where('is_accountable', true)->orderBy('code')->get();
        return response()->json($charts);
    }

    public function getSalesAccounts(Taxpayer $taxPayer, Cycle $cycle)
    {

        $charts = Chart::SalesAccounts()
        ->orderBy('name')
        ->select('name', 'id', 'type')
        ->get();

        return response()->json($charts);
    }

    // Accounts used in Purchase. Expense + Fixed Assets
    public function getPurchaseAccounts(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::PurchaseAccounts()
        ->orderBy('name')
        ->select('name', 'id', 'type')
        ->get();
        return response()->json($charts);
    }

    // Money Accounts
    public function getMoneyAccounts(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::MoneyAccounts()->orderBy('name')
        ->select('name', 'id', 'sub_type')
        ->get();
        return response()->json($charts);
    }

    // Debit VAT, used in Sales. Also Normal Sales Tax (Not VAT).
    public function getVATDebit(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::
        VATDebitAccounts()
        ->select('name', 'code', 'id', 'coefficient')
        ->get();

        return response()->json($charts);
    }

    // Credit VAT, used in Purchases
    public function getVATCredit(Taxpayer $taxPayer, Cycle $cycle)
    {
        $charts = Chart::
        VATCreditAccounts()
        ->select('name', 'code', 'id', 'coefficient')
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
        ->with('children:name')
        ->get();

        return response()->json($charts);
    }

    public function createIfNotExists_CashAccounts(Taxpayer $taxPayer, Cycle $cycle, $chart_id)
    {
        //Check if CustomerID exists in Chart.
        $chart = Chart::My($taxPayer, $cycle)
        ->where('id', $chart_id)
        ->first();

        if ($chart == null)
        {
            //if not, then look for generic.
            $chart = Chart::My($taxPayer, $cycle)
            ->where('type', 1)
            ->where('sub_type', 1)
            ->first();

            if ($chart == null)
            {
                //if not, create generic.
                $chart = new Chart();
                $chart->taxpayer_id = $taxPayer->id;
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->type = 1;
                $chart->sub_type = 1;
                $chart->is_accountable = true;
                $chart->code = 'N/A';
                $chart->name = __('enum.PettyCash');
                $chart->save();
            }
        }

        return $chart;
    }

    public function createIfNotExists_AccountsReceivables(Taxpayer $taxPayer, Cycle $cycle, $partnerID)
    {
        //Check if CustomerID exists in Chart.
        $chart = Chart::My($taxPayer, $cycle)
        ->where('partner_id', $partnerID)
        ->first();

        if ($chart == null)
        {
            //if not, then look for generic.
            $chart = Chart::My($taxPayer, $cycle)
            ->where('type', 1)
            ->where('sub_type', 5)
            ->where('is_accountable', true)
            ->first();

            if ($chart == null)
            {
                //if not, create generic.
                $chart = new Chart();
                $chart->taxpayer_id = $taxPayer->id;
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->partner_id = $partnerID;
                $chart->type = 1;
                $chart->sub_type = 5;
                $chart->is_accountable = true;
                $chart->code = 'N/A';
                $chart->name = __('commercial.AccountsReceivable') . ' ' . Taxpayer::find($partnerID)->name;
                $chart->save();
            }
        }

        return $chart;
    }

    public function createIfNotExists_AccountsPayable(Taxpayer $taxPayer, Cycle $cycle, $partnerID)
    {
        //Check if CustomerID exists in Chart.
        $chart = Chart::My($taxPayer, $cycle)
        ->where('partner_id', $partnerID)
        ->first();

        if ($chart == null)
        {
            //if not, then look for generic.
            $chart = Chart::My($taxPayer, $cycle)
            ->where('type', 2)
            ->where('sub_type', 1)
            ->first();

            if ($chart == null)
            {
                //if not, create generic.
                $chart = new Chart();
                $chart->taxpayer_id = $taxPayer->id;
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->partner_id = $partnerID;
                $chart->type = 2;
                $chart->sub_type = 1;
                $chart->is_accountable = true;
                $chart->code = 'N/A';
                $chart->name = __('commercial.AccountsPayable') . ' ' . Taxpayer::find($partnerID)->name;
                $chart->save();
            }
        }

        return $chart;
    }

    public function mergeCharts($fromChart, $toChart)
    {
        //update all transactions

        //update all transaction details

        //update all account movements

        //update all journal details

        //update all journal templates

        //update all journal simulation details

        //delete $fromCharts
    }
}
