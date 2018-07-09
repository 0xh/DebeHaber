<?php

use Laravel\Passport;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register the API routes for your application as
| the routes are automatically authenticated using the API guard and
| loaded automatically by this application's RouteServiceProvider.
|
*/

Route::post('status', 'API\Controller@checkServer');

Route::prefix('{country}')->group(function ()
{
    Route::get('/get_owner/{taxPayerID}', 'TaxpayerController@get_owner');
    Route::get('/get_taxpayers/{searchBy}', 'TaxpayerController@get_taxpayer');
});

Route::group(['middleware' => 'auth:api'], function ()
{});
    Route::post('/transactions', 'API\TransactionController@start');
    Route::post('/movement', 'API\AccountMovementController@start');
    Route::post('/check-key', 'API\Controller@checkAPI');
    Route::post('/check-server', 'API\Controller@checkServer');

    Route::get('/my-taxpayers/{teamID}/{userID}', 'TaxpayerIntegrationController@index');
    Route::get('/get_Allrate', 'CurrencyRateController@get_Allrate');

    Route::prefix('{country}')->group(function ()
    {
        Route::get('/get_owner/{taxPayerID}', 'TaxpayerController@get_owner');
        Route::get('/get_taxpayers/{searchBy}', 'TaxpayerController@get_taxpayer');
    });

    //Used for accepting or rejecting a team from accesing your taxpayer's data.
    Route::prefix('teams')->group(function ()
    {
        Route::post('/accpet-invite/{id}/{type}', 'HomeController@teamAccept')->name('team.accept');
        Route::post('/reject-invite/{id}', 'HomeController@teamReject')->name('team.reject');
    });

    Route::prefix('{taxPayer}')->group(function ()
    {
        // This creates taxpayers to be used only in Sales and Purchases. Not Taxpayers that will be used for accounting.
        Route::post('store-taxpayer', 'TaxpayerController@createTaxPayer');
        Route::get('hechuka/{startDate}/{endDate}', 'API\PRY\HechaukaController@generateFiles');

        Route::get('get_cycle', 'CycleController@get_cycle');
        Route::get('get_chartversion', 'ChartVersionController@get_chartversion');
        Route::get('get_currency', 'CurrencyController@get_currency');
        Route::get('get_rates/{currencyID}/{date?}', 'CurrencyRateController@get_ratesByCurrency');

        Route::get('get_documents/{type}', 'DocumentController@get_document');
        Route::get('get_allDocuments', 'DocumentController@get_Alldocument');
        Route::get('get_documentByID/{id}', 'DocumentController@get_documentByID');

        Route::prefix('{cycle}')->group(function ()
        {
            Route::prefix('accounting')->group(function ()
            {
                Route::get('journals/{skip}', 'JournalController@getJournals');
                Route::get('journal/ByID/{id}', 'JournalController@getJournalsByID');
                Route::get('delete_journalByID/{id}', 'JournalController@getJournalsByID');
                Route::post('journalstore', 'JournalController@journalstore');
                Route::post('cyclebudgetstore', 'CycleBudgetController@cyclebudgetstore');
                Route::get('journal/ByCycleID/{id}', 'JournalController@getJournalsByCycleID');
                Route::get('cyclebudget/ByCycleID/{id}', 'CycleBudgetController@getCycleBudgetsByCycleID');
                Route::prefix('chart')->group(function ()
                {
                    Route::get('charts/{skip}', 'ChartController@getCharts');
                    Route::get('charts/by-id/{id}', 'ChartController@getChartsByID');
                    Route::get('get-accountable_charts', 'ChartController@getAccountableCharts');
                    Route::get('get-accountable_charts/{frase}', 'ChartController@searchAccountableCharts');
                    Route::get('get-money_accounts', 'ChartController@getMoneyAccounts');
                    Route::get('get-parent_accounts/{frase}', 'ChartController@getParentAccount');
                    Route::post('merge/{fromChartId}/{toChartId}', 'ChartController@mergeCharts');
                });
                Route::prefix('fixedasset')->group(function ()
                {
                    Route::get('fixedassets/{skip}', 'FixedAssetController@getFixedAsset');
                    Route::get('fixedassets/by-id/{id}', 'FixedAssetController@getFixedAssetByID');

                });
                Route::prefix('journals')->group(function ()
                {
                    Route::get('list', 'JournalController@getJournals');
                    Route::get('by-id/{id}', 'JournalController@getJournalsByID');
                });
            });

            Route::prefix('commercial')->group(function ()
            {
                Route::get('sales/{skip}', 'SalesController@get_sales');
                Route::get('sales/by-id/{id}', 'SalesController@get_salesByID');
                Route::get('sales/default/{partnerID}', 'SalesController@getLastSale');
                Route::get('sales/last', 'SalesController@get_lastDate');
                Route::get('sales/get-charts', 'ChartController@getSalesAccounts');
                Route::get('sales/get-vats', 'ChartController@getVATDebit');

                Route::get('purchases/{skip}', 'PurchaseController@get_purchases');
                Route::get('purchases/by-id/{id}', 'PurchaseController@get_purchasesByID');
                Route::get('purchases/default/{partnerID}', 'PurchaseController@getLastPurchase');
                Route::get('purchases/get-charts', 'ChartController@getPurchaseAccounts');
                Route::get('purchases/get-vats', 'ChartController@getVATCredit');

                Route::get('credit-notes/{skip}', 'CreditNoteController@get_credit_note');
                Route::get('credit-notes/by-id/{id}', 'CreditNoteController@get_credit_noteByID');
                Route::get('credit-notes/get-charts', 'ChartController@getSalesAccounts');
                Route::get('credit-notes/get-vats', 'ChartController@getVATCredit');

                Route::get('debit-notes/{skip}', 'DebitNoteController@get_debit_note');
                Route::get('debit-notes/by-id/{id}', 'DebitNoteController@get_debit_noteByID');
                Route::get('debit-notes/get-charts', 'ChartController@getPurchaseAccounts');
                Route::get('debit-notes/get-vats', 'ChartController@getVATDebit');

                Route::get('account_receivables/{skip}', 'AccountReceivableController@get_account_receivable');
                Route::get('account_receivables/by-id/{id}', 'AccountReceivableController@get_account_receivableByID');
                Route::get('account_receivables/get-charts', 'ChartController@getMoneyAccounts');

                Route::get('account_payables/{skip}', 'AccountPayableController@get_account_payable');
                Route::get('account_payables/by-id/{id}', 'AccountPayableController@get_account_payableByID');
                Route::get('account_payables/get-charts', 'ChartController@getMoneyAccounts');


                Route::get('money_transfers/{skip}', 'MoneyTransferController@get_money_transfers');
                Route::get('money_transfer/by-id/{id}', 'MoneyTransferController@get_money_transferByID');

                Route::get('inventories/{skip}', 'InventoryController@getInventories');
                Route::post('inventories/get_InventoryChartType', 'InventoryController@get_InventoryChartType');
                Route::post('inventories/Calulate_sales', 'InventoryController@Calulate_sales');
                Route::post('inventories/Calulate_InvenotryValue', 'InventoryController@Calulate_InvenotryValue');
            });
        });


        Route::prefix('PRY')->group(function()
        {
            Route::get('/hechauka/{startDate}/{endDate}', 'API\PRY\HechukaController@getHechauka');
        });
    });

    Route::get('users', function()
    {
        return['username' => 'tao'];
    });


    Route::get('create-test-token', function() {
        $user = \App\User::find(1);
        // Creating a token without scopes...
        $token = $user->createToken('Test Token Name')->accessToken;
        return ['token' => $token];
    });
