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

Route::get('/', 'WelcomeController@show');

//No Team, maybe Team. No taxpayer selected
Route::get('/home', 'HomeController@show')->name('hello');
Route::get('/teamAccept/{integrationID}/{type}', 'HomeController@teamAccept')->name('Accept');
Route::get('/teamReject', 'HomeController@teamReject')->name('Reject');
Route::group(['middleware' => 'auth'], function ()
{


  Route::put('taxpayer-integration/{taxPayerIntegration}', 'TaxpayerIntegrationController@update');
  //Taxpayer Resource, CRUD
  Route::resource('taxpayer', 'TaxpayerController');

  //Takes the TaxPayer and puts it into the route passing it to Dashboard.
  Route::get('selectTaxPayer/{taxPayer}', 'TaxpayerController@selectTaxpayer')->name('selectTaxPayer');


  // ['middleware' => 'security'],
  Route::prefix('taxpayer/{taxPayer}/{cycle}')->group(function ()
  {
    Route::resource('CurrencyRate', 'CurrencyRateController');
    Route::resource('profile', 'TaxpayerController');
    Route::resource('settings', 'TaxpayerIntegrationController');

    //These Pages require Cycle in Session to perform searches and show relevant data.
    Route::get('stats', 'TaxpayerController@showDashboard')->name('taxpayer.dashboard');
    Route::get('cycles', 'CycleController@index')->name('cycles.index');
    Route::post('cycles/store', 'CycleController@store');
    //Route::resource('cycles', 'CycleController');
    Route::get('generate-journals/{startDate}/{endDate}/', 'JournalController@generateJournalsByRange')->name('journals.generate');

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
        'money-transfers' => 'AccountMovementController',
        'productions' => 'ProductionController',
        'fixed-assets' => 'FixedAssetController',
        'documents' => 'DocumentController'
      ]);
      Route::get('sales/anull/{transactionID}', 'SalesController@anull');
    });

    Route::prefix('/accounting')->group(function ()
    {
      Route::resources([
        'chart-versions' => 'ChartVersionController',
        'charts' => 'ChartController',
        'fixedasset' => 'FixedAssetController',
        'journals' => 'JournalController',
        'journal-templates' => 'JournalTemplateController',
        'journal-simulations' => 'JournalSimulationController'
      ]);
      // Route::get('generate-journals/{$startDate}/{$endDate}', 'JournalController@generateJournalsByRange')->name('journals.generate');
      Route::get('journals-by-charts', 'JournalController@indexByCharts')->name('journals.ByCharts');
      Route::get('charts/merge/{id}', 'ChartController@mergeChartsIndex')->name('charts.merge');
    });

    Route::prefix('reports')->group(function ()
    {
      Route::get('/', 'ReportController@index')->name('reports.index');
      Route::get('hechauka/generate_files/{start_date}/{end_date}', 'API\PRY\HechaukaController@generateFiles');

      Route::get('purchases/{strDate}/{endDate}/{e?}', 'ReportController@purchases')->name('reports.purchases');
      Route::get('purchases-byVAT/{strDate}/{endDate}/{e?}', 'ReportController@purchasesByVAT')->name('reports.purchaseByVAT');
      Route::get('purchases-bySupplier/{strDate}/{endDate}/', 'ReportController@purchasesBySupplier')->name('reports.purchaseBySupplier');
      Route::get('purchases-byChart/{strDate}/{endDate}/', 'ReportController@purchasesByChart')->name('reports.salesByChart');

      Route::get('sales/{strDate}/{endDate}/{e?}', 'ReportController@sales')->name('reports.sales');
      Route::get('sales-byVATs/{strDate}/{endDate}/{e?}', 'ReportController@salesByVAT')->name('reports.salesByVAT');
      Route::get('sales-byCustomers/{strDate}/{endDate}/{e?}', 'ReportController@salesByCustomer')->name('reports.salesByCustomer');
      Route::get('sales-byChart/{strDate}/{endDate}/{e?}', 'ReportController@salesByChart')->name('reports.salesByChart');

      Route::get('credit_notes/{strDate}/{endDate}/{e?}', 'ReportController@creditNotes')->name('reports.creditNotes');
      Route::get('debit_notes/{strDate}/{endDate}/{e?}', 'ReportController@debitNotes')->name('reports.debitNotes');

      Route::get('account-receivable/{strDate}/{endDate}/{e?}', 'ReportController@accountReceivable');
      Route::get('account-customer/{strDate}/{endDate}/{e?}', 'ReportController@accountCustomer');
      Route::get('account-payable/{strDate}/{endDate}/{e?}', 'ReportController@accountPayable');
      Route::get('account-supplier/{strDate}/{endDate}/{e?}', 'ReportController@accountSupplier');

      // Route::get('fx-rates/{strDate}/{endDate}/', 'ReportController@fxRates');

      Route::get('chart-ofAccounts/{strDate}/{endDate}/{e?}', 'ReportController@chartOfAccounts');

      Route::get('sub_ledger/{strDate}/{endDate}/{e?}', 'ReportController@subLedger')->name('reports.subLedger');
      Route::get('ledger/{strDate}/{endDate}/{e?}', 'ReportController@ledger')->name('reports.ledger');
      Route::get('ledger-byMonth/{strDate}/{endDate}/{e?}', 'ReportController@ledgerByMonth')->name('reports.ledgerByMonth');
      Route::get('ledger-byMoneyAccounts/{strDate}/{endDate}/{e?}', 'ReportController@ledgerByCashAccount');
      Route::get('ledger-byReceivables/{strDate}/{endDate}/{e?}', 'ReportController@ledgerByReceivables');
      Route::get('ledger-byPayables/{strDate}/{endDate}/{e?}', 'ReportController@ledgerByPayables');
      Route::get('ledger-byExpenses/{strDate}/{endDate}/{e?}', 'ReportController@ledgerByExpenses');

      Route::get('balance-sheet/{strDate}/{endDate}/', 'ReportController@balanceSheet')->name('reports.balanceSheet');
    });
  });
});
