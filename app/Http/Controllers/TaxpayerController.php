<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Taxpayer;
use App\TaxpayerIntegration;
use App\ChartVersion;
use App\Cycle;
use App\Chart;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaxpayerController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {

    }

    public function get_taxpayer($teamID, $frase)
    {
        $taxPayers = Taxpayer::search($frase)->get();

        return response()->json($taxPayers);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('taxpayer/profile');
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //TODO Request ID must be of Integration, not Taxpayer. From there you can know if taxpayer exists.

        //Check if taxPayer exists.
        //$taxPayer = $request->id == 0 ? new Taxpayer() : Taxpayer::find($request->id)->first();

        //Check Taxpayer by TaxID. If exists, use it, or else create it.
        $taxPayer = Taxpayer::where('taxid', $request->taxid)->where('country', 'PRY')->first();

        if (!isset($taxPayer))
        {
            $taxPayer= new Taxpayer();
            $taxPayer->name = $request->name;
        }

        //TODO Country from Selection Box
        if ($taxPayer->taxid >0 )
        {
            $taxPayer->taxid = $request->taxid;
        }

        $taxPayer->code = $request->code;

        $taxPayer->alias = $request->alias;
        $taxPayer->address = $request->address;
        $taxPayer->telephone = $request->telephone;
        $taxPayer->email = $request->email;

        $taxPayer->save();

        $current_date = Carbon::now();
        $chartVersion = ChartVersion::where(function($query) use($taxPayer)
        {
            $query
            ->where('taxpayer_id', $taxPayer->id)
            ->orWhere('taxpayer_id', null);
        })
        ->first();

        if (!isset($chartVersion))
        {
            $chartVersion = new ChartVersion();
            $chartVersion->name = $current_date->year;
            $chartVersion->taxpayer_id = $taxPayer->id;
            $chartVersion->save();
        }

        $cycle = Cycle::where('chart_version_id', $chartVersion->id)
        ->where('taxpayer_id', $taxPayer->id)
        ->first();

        if (!isset($cycle))
        {
            $cycle = new Cycle();
        }

        $cycle->chart_version_id = $chartVersion->id;
        $cycle->year = $current_date->year;
        $cycle->start_date = new Carbon('first day of January');
        $cycle->end_date = new Carbon('last day of December');
        $cycle->taxpayer_id = $taxPayer->id;
        $cycle->save();

        $existingtaxpayerIntegration = TaxpayerIntegration::where('team_id', Auth::user()->current_team_id)->first();
        $taxpayerIntegration = new TaxpayerIntegration();

        if (!isset($existingtaxpayerIntegration))
        {
            $taxpayerIntegration->is_owner = 1;
        }
        else
        {
            $taxpayerIntegration->is_owner = 0;
        }

        $taxpayerIntegration->taxpayer_id = $taxPayer->id;
        $taxpayerIntegration->team_id = Auth::user()->current_team_id;
        $taxpayerIntegration->type = 1;

        $taxpayerIntegration->is_company = 1;
        $taxpayerIntegration->save();

        //TODO Check if Default Version is available for Country.
        return response()->json('ok');
    }

    //This is for Customers or Suppliers that are also Taxpayers.
    public function createTaxPayer(Request $request, Taxpayer $taxPayer)
    {
        $customerOrSupplier = Taxpayer::where('taxid', $request->taxid)->where('country', $taxPayer->country)->first();

        if (!isset($customerOrSupplier))
        {
            $customerOrSupplier= new Taxpayer();
            $customerOrSupplier->name = $request->name;
        }

        //TODO Country from Selection Box
        $customerOrSupplier->taxid = $request->taxid;
        $customerOrSupplier->code = $request->code;

        $customerOrSupplier->alias = $request->alias;
        $customerOrSupplier->address = $request->address;
        $customerOrSupplier->telephone = $request->telephone;
        $customerOrSupplier->email = $request->email;

        $customerOrSupplier->save();
        return response()->json('ok');
    }

    /**
    * Display the specified resource.
    *
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function show(Taxpayer $taxPayer)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function edit(Taxpayer $taxPayer)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Taxpayer $taxPayer)
    {
        //
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Taxpayer  $taxpayer
    * @return \Illuminate\Http\Response
    */
    public function destroy(Taxpayer $taxPayer)
    {
        //
    }

    public function showDashboard(Taxpayer $taxPayer, Cycle $cycle)
    {
        $chartsAccountable = Chart::where('is_accountable', true)->pluck('type', 'sub_type')->get();
        $chartFixedAssets = $chartsAccountable->where('type', 1)->where('sub_type', 9)->count();
        $chartMoneyAccounts = $chartsAccountable->where('type', 1)->where('sub_type', 1)->count();
        $chartExpenses = $chartsAccountable->where('type', 5)->count();
        $chartInventories = $chartsAccountable->where('type', 1)->where('sub_type', 8)->count();
        $chartIncomes = $chartsAccountable->where('type', 4)->count();

        $totalSales = Transaction::MySales()
        ->whereBetween('date', [new Carbon('first day of last month'), new Carbon('last day of last month')])
        ->where('supplier_id', $taxPayer->id)
        ->count();

        $totalPurchases = Transaction::MyPurchases()
        ->whereBetween('date', [new Carbon('first day of last month'), new Carbon('last day of last month')])
        ->where('customer_id', $taxPayer->id)
        ->count();

        return view('taxpayer/dashboard')
        ->with('chartFixedAssets', $chartFixedAssets)
        ->with('chartMoneyAccounts', $chartMoneyAccounts)
        ->with('chartExpenses', $chartExpenses)
        ->with('chartInventories', $chartInventories)
        ->with('chartIncomes', $chartIncomes)
        ->with('totalSales', $totalSales)
        ->with('totalPurchases', $totalPurchases);
    }

    public function selectTaxpayer(Taxpayer $taxPayer)
    {
        //Get current month sub 1 month.
        $workingYear = Carbon::now()->subMonth(1)->year;
        //Check if there is Cycle of current year.
        $cycle = Cycle::where('year', $workingYear)->first();

        //If null, then create it.
        if ($cycle == null)
        {
            //TODO Get Last ChartVersion or Default.
            $chartVersion = 1;

            $cycle = new Cycle();
            $cycle->chart_version_id = $chartVersion; //->id;
            $cycle->year = $workingYear;
            $cycle->start_date = new Carbon('first day of January ' . $workingYear);
            $cycle->end_date = new Carbon('last day of December ' . $workingYear);
            $cycle->taxpayer_id = $taxPayer->id;
            $cycle->save();
        }

        //run code to check for fiscal year selection and create if not.
        return redirect()->route('taxpayer.dashboard', [$taxPayer, $cycle]);
    }
}
