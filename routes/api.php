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

  Route::get('/my-taxpayers/{teamID}/{userID}', 'TaxpayerIntegrationController@index');
  Route::get('/get_Allrate', 'CurrencyRateController@get_Allrate');
  Route::post('/syncData', 'API\TransactionController@start');

  Route::prefix('{taxPayer}')->group(function ()
  {
    // This creates taxpayers to be used only in Sales and Purchases. Not Taxpayers that will be used for accounting.
    Route::post('store-taxpayer', 'TaxpayerController@createTaxPayer');

    Route::get('get_cycle', 'CycleController@get_cycle');
    Route::get('get_chartversion', 'ChartVersionController@get_chartversion');
    Route::get('get_currency', 'CurrencyController@get_currency');
    Route::get('get_rateByCurrency/{currencyID}/{date}', 'CurrencyRateController@get_rateByCurrency');
    Route::get('get_document/{type}', 'DocumentController@get_document');
    Route::get('get_Alldocument', 'DocumentController@get_Alldocument');
    Route::get('get_documentByID/{id}', 'DocumentController@get_documentByID');
    Route::get('get_taxpayer/{frase}', 'TaxpayerController@get_taxpayer');

    Route::prefix('{cycle}')->group(function ()
    {
      Route::prefix('accounting')->group(function ()
      {
        Route::prefix('chart')->group(function ()
        {
          Route::get('get', 'ChartController@getCharts');
          Route::get('get_item-sales', 'ChartController@getSalesAccounts');
          Route::get('get_item-purchases', 'ChartController@getPurchaseAccounts');
          Route::get('get_money-accounts', 'ChartController@getMoneyAccounts');
          Route::get('get_parent-accounts/{frase}', 'ChartController@getParentAccount');
          Route::get('get_vat-debit', 'ChartController@getVATDebit');
          Route::get('get_vat-credit', 'ChartController@getVATCredit');
        });
        Route::prefix('journal')->group(function ()
        {
          Route::get('get', 'JournalController@getJournals');
          Route::get('getJournalsByID/{id}', 'JournalController@getJournalsByID');

        });
      });

      Route::prefix('commercial')->group(function ()
      {
        Route::get('get_sales', 'SalesController@get_sales');
        Route::get('get_salesByID/{id}', 'SalesController@get_salesByID');
        Route::get('get_lastDate', 'SalesController@get_lastDate');

        Route::get('get_purchases', 'PurchaseController@get_purchases');
        Route::get('getLastPurchase', 'PurchaseController@getLastPurchase');
        Route::get('get_purchasesByID/{id}', 'PurchaseController@get_purchasesByID');

        Route::get('get_credit_note', 'CreditNoteController@get_credit_note');
        Route::get('get_credit_noteByID/{id}', 'CreditNoteController@get_credit_noteByID');

        Route::get('get_debit_note', 'DebitNoteController@get_debit_note');
        Route::get('get_debit_noteByID/{id}', 'DebitNoteController@get_debit_noteByID');

        Route::get('get_account_receivable', 'AccountReceivableController@get_account_receivable');
        Route::get('get_account_receivableByID/{id}', 'AccountReceivableController@get_account_receivableByID');

        Route::get('get_account_payable', 'AccountPayableController@get_account_payable');
        Route::get('get_account_payableByID/{id}', 'AccountPayableController@get_account_payableByID');
      });
    });
    Route::group(['middleware' => 'auth:api'], function ()
    {
  });


  Route::get('users', function()
  {
    return['username' => 'tao'];
  });
});

Route::get('create-test-token', function() {
  $user = \App\User::find(1);
  // Creating a token without scopes...
  $token = $user->createToken('Test Token Name')->accessToken;
  return ['token' => $token];
});
