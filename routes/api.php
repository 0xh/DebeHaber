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

Route::group(['middleware' => 'auth:api'], function ()
{
});
Route::post('/syncData', 'API\TransactionController@start');

Route::get('/my-taxpayers/{teamID}/{userID}', 'TaxpayerIntegrationController@index');
Route::get('/get_Allrate', 'CurrencyRateController@get_Allrate');

Route::prefix('{taxPayer}')->group(function ()
{
    // This creates taxpayers to be used only in Sales and Purchases. Not Taxpayers that will be used for accounting.
    Route::post('store-taxpayer', 'TaxpayerController@createTaxPayer');
    Route::get('hechuka/{startDate}/{endDate}', 'API\PRY\HechaukaController@generateFiles');

    Route::get('get_cycle', 'CycleController@get_cycle');
    Route::get('get_chartversion', 'ChartVersionController@get_chartversion');
    Route::get('get_currency', 'CurrencyController@get_currency');
    Route::get('get_buyRateByCurrency/{currencyID}/{date}', 'CurrencyRateController@get_buyRateByCurrency');
    Route::get('get_sellRateByCurrency/{currencyID}/{date}', 'CurrencyRateController@get_sellRateByCurrency');

    Route::get('get_documents/{type}', 'DocumentController@get_document');
    Route::get('get_allDocuments', 'DocumentController@get_Alldocument');
    Route::get('get_documentByID/{id}', 'DocumentController@get_documentByID');
    Route::get('get_taxpayers/{frase}', 'TaxpayerController@get_taxpayer');

    Route::prefix('{cycle}')->group(function ()
    {
        Route::prefix('accounting')->group(function ()
        {
            Route::get('journals/{skip}', 'JournalController@getJournals');
            Route::get('journal/ByID/{id}', 'JournalController@getJournalsByID');
            Route::get('delete_journalByID/{id}', 'JournalController@getJournalsByID');

            Route::prefix('chart')->group(function ()
            {
                Route::get('charts/{skip}', 'ChartController@getCharts');
                Route::get('charts/ByID/{id}', 'ChartController@getChartsByID');
                Route::get('get_accountable-charts', 'ChartController@getAccountableCharts');
                Route::get('get_money-accounts', 'ChartController@getMoneyAccounts');
                Route::get('get_parent-accounts/{frase}', 'ChartController@getParentAccount');
            });
            Route::prefix('journals')->group(function ()
            {
                Route::get('list', 'JournalController@getJournals');
                Route::get('id/{id}', 'JournalController@getJournalsByID');
            });
        });

        Route::prefix('commercial')->group(function ()
        {
            Route::get('sales/{skip}', 'SalesController@get_sales');
            Route::get('sales/config/{partnerID}', 'SalesController@getLastSale');
            Route::get('sales/start', 'SalesController@get_lastDate');
            Route::get('sales/by-id/{id}', 'SalesController@get_salesByID');
            Route::get('sales/get-charts', 'ChartController@getSalesAccounts');
            Route::get('sales/get-vats', 'ChartController@getVATDebit');

            Route::get('purchases/{skip}', 'PurchaseController@get_purchases');
            Route::get('purchases/config/{partnerID}', 'PurchaseController@getLastPurchase');
            Route::get('purchases/start', 'PurchaseController@get_lastDate');
            Route::get('purchases/by-id/{id}', 'PurchaseController@get_purchasesByID');
            Route::get('purchases/get-charts', 'ChartController@getPurchaseAccounts');
            Route::get('purchases/get-vats', 'ChartController@getVATCredit');

            Route::get('credit_notes/{skip}', 'CreditNoteController@get_credit_note');
            Route::get('credit_notes/start', 'CreditNoteController@get_lastDate');
            Route::get('credit_notes/by-id/{id}', 'CreditNoteController@get_credit_noteByID');
            Route::get('credit_notes/get-charts', 'ChartController@getSalesAccounts');
            Route::get('credit_notes/get-vats', 'ChartController@getVATCredit');

            Route::get('debit_notes/{skip}', 'DebitNoteController@get_debit_note');
            Route::get('debit_notes/start', 'CreditNoteController@get_lastDate');
            Route::get('debit_notes/by-id/{id}', 'DebitNoteController@get_debit_noteByID');
            Route::get('debit_notes/get-charts', 'ChartController@getPurchaseAccounts');
            Route::get('debit_notes/get-vats', 'ChartController@getVATDebit');

            Route::get('account_receivables/{skip}', 'AccountReceivableController@get_account_receivable');
            // Route::get('account_receivable/ByID/{id}', 'AccountReceivableController@get_account_receivableByID');

            Route::get('account_payables/{skip}', 'AccountPayableController@get_account_payable');
            // Route::get('account_payable/ByID/{id}', 'AccountPayableController@get_account_payableByID');

            Route::get('money_transfers/{skip}', 'MoneyTransferController@get_money_transfers');
            Route::get('money_transfer/ByID/{id}', 'MoneyTransferController@get_money_transferByID');
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
