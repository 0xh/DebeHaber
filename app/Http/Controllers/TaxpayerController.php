<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\Taxpayer;
use App\TaxpayerIntegration;
use App\TaxpayerSetting;
use App\TaxpayerType;
use App\ChartVersion;
use App\Cycle;
use App\Chart;
use App\Team;
use App\User;
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

  public function get_taxpayer($teamID, $query)
  {
    $taxPayers = Taxpayer::search($query)->take(10)->get();
    return response()->json($taxPayers);
  }

  public function get_owner($taxpayer,$id)
  {
    $taxPayer = Taxpayer::where('id',$id)->first();
    if (isset($taxPayer)) {
      $taxpayerintegration=TaxpayerIntegration
      ::where('taxpayer_id',$taxPayer->id)->select('team_id')->first();
      if (isset($taxpayerintegration)) {
        $team=Team::where('id',$taxpayerintegration->team_id)->select('owner_id')->first();
        if (isset($team)) {
          $user=User::where('id',$team->owner_id)->first();
          return response()->json($user);
        }
      }



    }
    return response()->json(null);
  }


  /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
  public function create()
  {
    return view('taxpayer/form');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function store(Request $request)
  {
    //Used below for date and year.
    $current_date = Carbon::now();

    //TODO Request ID must be of Integration, not Taxpayer. From there you can know if taxpayer exists.


    //Check Taxpayer by TaxID. If exists, use it, or else create it.
    $taxPayer = Taxpayer::where('taxid', $request->taxid)
    ->where('country', Auth::user()->country)
    ->first();

    //If taxpayer does not exist, then create it.
    if (!isset($taxPayer))
    {
      $taxPayer= new Taxpayer();
      $taxPayer->name = $request->name;
      $taxPayer->taxid = $request->taxid > 0 ? $request->taxid : 0 ;
      $taxPayer->code = $request->code;
    }

    //Update basic information
    $taxPayer->alias = $request->alias;
    $taxPayer->address = $request->address;
    $taxPayer->telephone = $request->telephone;
    $taxPayer->email = $request->email;
    $taxPayer->save();

    $chartVersion = ChartVersion::where('country', $taxPayer->country)
    ->where(function($query) use($taxPayer)
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
      $chartVersion->country = $taxPayer->country;
      $chartVersion->save();
    }

    $cycle = Cycle::where('chart_version_id', $chartVersion->id)
    ->where('taxpayer_id', $taxPayer->id)
    ->first();

    if (!isset($cycle))
    { $cycle = new Cycle(); }

    $cycle->chart_version_id = $chartVersion->id;
    $cycle->year = $current_date->year;
    $cycle->start_date = new Carbon('first day of January');
    $cycle->end_date = new Carbon('last day of December');
    $cycle->taxpayer_id = $taxPayer->id;
    $cycle->save();

    $bool_IntegrationExists = TaxpayerIntegration::where('team_id', Auth::user()->current_team_id)->exists();

    //Even though integration exists, you need to create a new integration that is specific for this team.
    $taxPayer_Integration = new TaxpayerIntegration();
    $taxPayer_Integration->is_owner = $bool_IntegrationExists == true ? 0 : 1;
    $taxPayer_Integration->status = $bool_IntegrationExists == true ? 1 : 2;
    $taxPayer_Integration->taxpayer_id = $taxPayer->id;
    $taxPayer_Integration->team_id = Auth::user()->current_team_id;
    $taxPayer_Integration->type = $request->type ?? 1; //Default to 1 if nothing is selected
    $taxPayer_Integration->save();

    $taxPayer_Setting = $bool_IntegrationExists ? TaxpayerSetting::where('taxpayer_id', $taxPayer->id)->first() : new TaxpayerSetting();
    $taxPayer_Setting->taxpayer_id = $taxPayer->id;
    // $taxPayer_Setting->show_inventory = $request->show_inventory = true ? 1 : 0;
    // $taxPayer_Setting->show_production = $request->show_production = true ? 1 : 0;
    // $taxPayer_Setting->show_fixedasset = $request->show_fixedasset = true ? 1 : 0;
    //$taxPayer_Setting->is_company = 1;
    $taxPayer_Setting->save();

    //TODO Check if Default Version is available for Country.
    return response()->json('ok', 200);
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

    return response()->json('ok', 200);
  }

  /**
  * Display the specified resource.
  *
  * @param  \App\Taxpayer  $taxpayer
  * @return \Illuminate\Http\Response
  */
  public function show($taxPayer, Cycle $cycle)
  {
    $taxPayer=Taxpayer::where('id',$taxPayer)->get();

    return view('taxpayer/profile')->with('taxPayer', $taxPayer);
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
    $taxPayer = Taxpayer::find($taxPayer->id);

    if (isset($taxPayer))
    {
      $taxPayer->name = $request->name;
      $taxPayer->taxid = $request->taxid > 0 ? $request->taxid : 0 ;
      $taxPayer->code = $request->code;
      $taxPayer->alias = $request->alias;
      $taxPayer->address = $request->address;
      $taxPayer->telephone = $request->telephone;
      $taxPayer->email = $request->email;
      $taxPayer->save();

      $taxPayer_Setting = TaxpayerSetting::where('taxpayer_id', $taxPayer->id)->first() ?? new TaxpayerSetting();
      $taxPayer_Setting->taxpayer_id = $taxPayer->id;
      $taxPayer_Setting->agent_taxid = $request->agent_taxid;
      $taxPayer_Setting->agent_name = $request->agent_name;
      $taxPayer_Setting->save();

      $taxpayertypes = TaxpayerType::where('taxpayer_id', $taxPayer->id)->get();

      if (isset($taxpayertypes))
      {
        foreach ($taxpayertypes as $taxpayertype)
        {
          $taxpayertype->delete();
        }
      }

      if (isset($request->type)) {
        foreach ($request->type as  $value) {
          $taxpayertype = new TaxpayerType();
          $taxpayertype->taxpayer_id = $taxPayer->id;
          $taxpayertype->type = $value;
          $taxpayertype->save();
        }
      }

      return response()->json('ok', 200);
    }

    return response()->json('Failed', 500);
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
    $chartsAccountable = 1;//Chart::where('is_accountable', true)->pluck('type', 'sub_type')->get();
    $chartFixedAssets = 1;//$chartsAccountable->where('type', 1)->where('sub_type', 9)->count();
    $chartMoneyAccounts = 1;//$chartsAccountable->where('type', 1)->where('sub_type', 1)->count();
    $chartExpenses = 1;//$chartsAccountable->where('type', 5)->count();
    $chartInventories = 1;//$chartsAccountable->where('type', 1)->where('sub_type', 8)->count();
    $chartIncomes = 1;//$chartsAccountable->where('type', 4)->count();

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

  public function selectTaxpayer(Request $request,Taxpayer $taxPayer)
  {
    //Get current month sub 1 month.
    $workingYear = Carbon::now()->subMonth(1)->year;

    //Check if there is Cycle of current year.
    $cycle = Cycle::where('year', $workingYear)
    ->where('taxpayer_id', $taxPayer->id)
    ->first();

    //If null, then create it.
    if ($cycle == null)
    {
      //TODO Get Last ChartVersion or Default..
      $chartVersion = ChartVersion::where('country', $taxPayer->country)->first() ?? new ChartVersion();
      if ($chartVersion->id != null || $chartVersion->id == 0)
      {
        $chartVersion->country = $taxPayer->country;
        $chartVersion->name = "Generic";
        $chartVersion->save();
      }

      $cycle = new Cycle();
      $cycle->chart_version_id = $chartVersion; //->id;
      $cycle->year = $workingYear;
      $cycle->start_date = new Carbon('first day of January ' . $workingYear);
      $cycle->end_date = new Carbon('last day of December ' . $workingYear);
      $cycle->taxpayer_id = $taxPayer->id;
      $cycle->save();
    }

    $setting = $taxPayer->setting ?? new TaxpayerSetting();
    if ($setting->id != null || $setting->id == 0)
    {
      $setting->taxpayer_id = $taxPayer->id;
      $setting->save();
    }

    //run code to check for fiscal year selection and create if not.
    return redirect()->route('taxpayer.dashboard', [$taxPayer, $cycle]);
  }
}
