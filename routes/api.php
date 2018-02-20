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

Route::group(['middleware' => 'auth:api'], function ()
{

  Route::get('users', function()
  {
    return['username' => 'tao'];
  });

  //Get taxPayer List -> through Elastic Search

  //Get Charts with is_accountable = true


  Route::get('/get_chart', 'ChartController@get_chart');
  //Get All Charts by Version
  Route::get('/get_chartversion', 'ChartVersionController@get_chartversion');
  //Get
  Route::get('/get_cycle', 'CycleController@get_cycle');
});

Route::get('create-test-token', function() {
  $user = \App\User::find(1);
  // Creating a token without scopes...
  $token = $user->createToken('Test Token Name')->accessToken;
  return ['token' => $token];
});
