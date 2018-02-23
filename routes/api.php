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
Route::get('/get_cycle/{teamID}', 'CycleController@get_cycle');
Route::get('/get_chartversion/{teamID}', 'ChartVersionController@get_chartversion');
Route::get('/get_product/{teamID}', 'ChartController@get_product');
Route::get('/get_tax/{teamID}', 'ChartController@get_tax');
Route::get('/get_sales/{teamID}', 'SalesController@get_sales');
Route::get('/get_salesByID/{teamID}/{id}', 'SalesController@get_salesByID');
Route::get('/get_currency/{teamID}', 'CurrencyController@get_currency');
Route::get('/get_document/{type}/{teamID}', 'DocumentController@get_document');
Route::get('/get_taxpayer/{teamID}', 'TaxpayerController@get_taxpayer');
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
