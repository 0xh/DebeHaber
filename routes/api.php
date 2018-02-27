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

Route::prefix('taxpayer/{taxPayer}/{cycle}')->group(function ()
{
    Route::get('get_cycle', 'CycleController@get_cycle');
    Route::get('get_chartversion', 'ChartVersionController@get_chartversion');
});



Route::get('/get_product/{$taxPayerID}', 'ChartController@get_product');

Route::get('/get_account/{$taxPayerID}', 'ChartController@get_account');

Route::get('/get_tax/{$taxPayerID}', 'ChartController@get_tax');

Route::get('/get_sales/{$taxPayerID}', 'SalesController@get_sales');

Route::get('/get_salesByID/{$taxPayerID}/{id}', 'SalesController@get_salesByID');

Route::get('/get_purchases/{$taxPayerID}', 'PurchaseController@get_purchases');

Route::get('/get_purchasesByID/{$taxPayerID}/{id}', 'PurchaseController@get_purchasesByID');

Route::get('/get_credit_note/{$taxPayerID}', 'CreditNoteController@get_credit_note');

Route::get('/get_credit_noteByID/{$taxPayerID}/{id}', 'CreditNoteController@get_credit_noteByID');

Route::get('/get_debit_note/{$taxPayerID}', 'DebitNoteController@get_debit_note');

Route::get('/get_debit_noteByID/{$taxPayerID}/{id}', 'DebitNoteController@get_debit_noteByID');

Route::get('/get_currency/{$taxPayerID}', 'CurrencyController@get_currency');

Route::get('/get_rateByCurrency/{$taxPayerID}/{id}/{date}', 'CurrencyRateController@get_rateByCurrency');

Route::get('/get_document/{type}/{$taxPayerID}', 'DocumentController@get_document');

Route::get('/get_taxpayer/{$taxPayerID}', 'TaxpayerController@get_taxpayer');

Route::get('/get_account_receivable/{$taxPayerID}', 'AccountReceivableController@get_account_receivable');

Route::get('/get_account_receivableByID/{$taxPayerID}/{id}', 'AccountReceivableController@get_account_receivableByID');

Route::get('/get_account_payable/{$taxPayerID}', 'AccountPayableController@get_account_payable');

Route::get('/get_account_payableByID/{$taxPayerID}/{id}', 'AccountPayableController@get_account_payableByID');

Route::group(['middleware' => 'auth:api'], function ()
{
    Route::get('users', function()
    {
        return['username' => 'tao'];
    });

    //Get taxPayer List -> through Elastic Search

    //Get Charts with is_accountable = true



    //Get All Charts by Version

    //Get

});

Route::get('create-test-token', function() {
    $user = \App\User::find(1);
    // Creating a token without scopes...
    $token = $user->createToken('Test Token Name')->accessToken;
    return ['token' => $token];
});
