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
Route::get('/home', 'HomeController@show');

Route::group(['middleware' => 'auth'], function ()
{
    //create taxpayer
    Route::resource('taxpayer', 'TaxpayerController');

    Route::prefix('/{taxPayer}')->group(function ()
    {

        Route::get('/dashboard/{cycle?}', 'TaxpayerController@showDashboard')->name('taxpayer.dashboard');
        Route::resource('chart-versions', 'ChartVersionController');
        Route::resource('cycle', 'CycleController');

        Route::prefix('/{cycle}')->group(function ()
        {
            Route::prefix('/commercial')->group(function ()
            {
                Route::resources([
                    'sales' => 'SalesController',
                    'account-receivables' => 'AccountReceivableController',
                    'credit-notes' => 'CreditNoteController',
                    'impex/imports' => 'ImpexImportController',

                    'purchases' => 'PurchaseController',
                    'account-payables' => 'AccountPayableController',
                    'debit-notes' => 'DebitNoteController',
                    'impex/exports' => 'ImpexExportController',

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
                    'charts' => 'ChartController',
                    'journals' => 'JournalController',
                    'journal-templates' => 'JournalTemplateController',
                    'journal-simulations' => 'JournalSimulationController'
                ]);

                Route::get('journals-by-charts', 'JournalController@indexByCharts')->name('journals.ByCharts');
            });

            Route::prefix('/reports/{country?}')->group(function ()
            {
                Route::get('/', 'ReportController@index');

                Route::get('hechauka/generate_files/{start_date}/{end_date}', 'HechaukaController@generateFiles');

                Route::get('purchase-vat/{strDate}/{endDate}', 'ReportController@vatPurchase')->name('reports.purchaseVAT');
                Route::get('purchase-vat-bySupplier/{strDate}/{endDate}/', 'ReportController@vatPurchase_GroupBySupplier');
                Route::get('purchase-vat-byCenter/{strDate}/{endDate}/', 'ReportController@vatPurchase_GroupByBusinessCenter');
                Route::get('purchase-vat-byBranch/{strDate}/{endDate}/', 'ReportController@vatPurchase_GroupByBranch');

                Route::get('sales-vat/{strDate}/{endDate}', 'ReportController@vatSales')->name('reports.salesVAT');
                Route::get('sales-vat-byCustomer/{strDate}/{endDate}/', 'ReportController@vatSales_GroupByCustomer');
                Route::get('sales-vat-byCenter/{strDate}/{endDate}/', 'ReportController@vatSales_GroupByBusinessCenter');
                Route::get('sales-vat-byBranch/{strDate}/{endDate}/', 'ReportController@vatSales_GroupByBranch');

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
});
