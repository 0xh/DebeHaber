<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//to Test only
Route::get('/get_taxpayers/{searchable}', function ($text)
{
    return App\Taxpayer::search($text)->get();
});



Route::get('/', 'WelcomeController@show');

//No Team, maybe Team. No taxpayer selected
Route::get('/home', 'HomeController@show')->name('hello');

Route::group(['middleware' => 'auth'], function ()
{
  //Taxpayer Resource, CRUD
  Route::resource('taxpayer', 'TaxpayerController');

  //Takes the TaxPayer and puts it into the route passing it to Dashboard.
  Route::get('selectTaxPayer/{taxPayer}', 'TaxpayerController@selectTaxpayer')->name('selectTaxPayer');
  Route::resource('CurrencyRate', 'CurrencyRateController');

  // ['middleware' => 'security'],
  Route::prefix('taxpayer/{taxPayer}/{cycle}')->group(function ()
  {
    //These Pages require Cycle in Session to perform searches and show relevant data.
    Route::get('stats', 'TaxpayerController@showDashboard')->name('taxpayer.dashboard');
    Route::get('cycles', 'CycleController@index')->name('cycles.index');
    Route::post('generateJournals', 'JournalController@generateJournals');

    Route::prefix('commercial')->group(function ()
    {
      Route::resources([
        'sales' => 'SalesController',
        'account-receivables' => 'AccountReceivableController',
        'credit-notes' => 'CreditNoteController',
        'impex-exports' => 'ImpexExportController',

        'purchases' => 'PurchaseController',
        'account-payables' => 'AccountPayableController',
        'debit-notes' => 'DebitNoteController',
        'impex-imports' => 'ImpexImportController',

        'inventories' => 'InventoryController',
        'money-transfers' => 'MoneyTransferController',
        'productions' => 'ProductionController',
        'fixed-assets' => 'FixedAssetController',
        'documents' => 'DocumentController'
      ]);
    });

    Route::prefix('/accounting')->group(function ()
    {
      Route::resources([
        'chart-versions' => 'ChartVersionController',
        'charts' => 'ChartController',
        'journals' => 'JournalController',
        'journal-templates' => 'JournalTemplateController',
        'journal-simulations' => 'JournalSimulationController'
      ]);

      Route::get('journals-by-charts', 'JournalController@indexByCharts')->name('journals.ByCharts');
    });

    Route::prefix('reports')->group(function ()
    {
      Route::get('/', 'ReportController@index')->name('reports.index');

      Route::get('hechauka/generate_files/{start_date}/{end_date}', 'API\PRY\HechaukaController@generateFiles');

      Route::get('purchases/{strDate}/{endDate}', 'ReportController@purchases')->name('reports.purchases');
      Route::get('purchases-byVAT/{strDate}/{endDate}', 'ReportController@purchasesByVAT')->name('reports.purchaseByVAT');
      Route::get('purchases-bySupplier/{strDate}/{endDate}/', 'ReportController@purchasesBySupplier')->name('reports.salesByCustomer');
      Route::get('purchases-byChart/{strDate}/{endDate}/', 'ReportController@purchasesByChart')->name('reports.salesByChart');

      Route::get('sales/{strDate}/{endDate}', 'ReportController@sales')->name('reports.sales');
      Route::get('sales-byVAT/{strDate}/{endDate}', 'ReportController@salesByVAT')->name('reports.salesByVAT');
      Route::get('sales-byCustomer/{strDate}/{endDate}/', 'ReportController@salesByCustomer')->name('reports.salesByCustomer');
      Route::get('sales-byChart/{strDate}/{endDate}/', 'ReportController@salesByChart')->name('reports.salesByChart');

      Route::get('fx-rates/{strDate}/{endDate}/', 'ReportController@fxRates');

      Route::get('account-customer/{strDate}/{endDate}/', 'ReportController@accountCustomer');
      Route::get('account-supplier/{strDate}/{endDate}/', 'ReportController@accountSupplier');

      Route::get('journal/{strDate}/{endDate}/', 'ReportController@journal');
      Route::get('journal-ByChart/{strDate}/{endDate}/', 'ReportController@journal_ByChart');
      Route::get('journal-ByDate/{strDate}/{endDate}/', 'ReportController@journal_ByDate');
      Route::get('journal-ByEntry/{strDate}/{endDate}/', 'ReportController@journal_ByEntry');

      Route::get('balance-sums-balances/{strDate}/{endDate}/', 'ReportController@balanceSumsBalances');
      Route::get('balance-comparative/{strDate}/{endDate}/', 'ReportController@balanceComparative');
      Route::get('balance-sheet/{strDate}/{endDate}/', 'ReportController@balanceSheet');
      Route::get('results/{strDate}/{endDate}/', 'ReportController@resultsTable');
      Route::get('cash-flow/{strDate}/{endDate}/', 'ReportController@cashFlow');
    });
  });
});
